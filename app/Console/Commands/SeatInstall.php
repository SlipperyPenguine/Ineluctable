<?php
/*
The MIT License (MIT)

Copyright (c) 2014 eve-seat

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

namespace ineluctable\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SeatInstall extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'seat:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs SeAT.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Write configiguration to base_path()/.env.php
     *
     * @return bool
     */
    public function writeConfig($configuration)
    {

        // Prepare the file based off the values in the
        // $configuration array
        //$config_file = '// SeAT Configuration Created: ' . date('Y-m-d H:i:s') . "\n\n" .
        //    'return ' . var_export($configuration, true) . ";\n";

        $config_file = '// SeAT Configuration Created: ' . date('Y-m-d H:i:s') . "\n\n" ;




        foreach ($configuration as $key => $value)
        {
            $config_file.=$key.'='.$value."\n";
        }

        // Write the configuration file to disk
        $file_write = \File::put(base_path() . '/.env', $config_file);

        // Ensure the write was successful
        if ($file_write === false ) {

            $this->error('[!] Writing the configuration file to ' . base_path() . '/.env failed!');
            return false;
        }

        return true;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {


        // Certain stages of this installer will require variables
        // to be opulated, which will eventually be used to
        // write the resultant configuration file. Some
        // stages require testing too, so lets
        // prepare some defaults that will
        // be used.
        $configuration = array(
            'APP_ENV'    => 'production',
            'APP_DEBUG'    => 'false',
            'APP_KEY'    => '6k5dT8HGOfIG2u4uoYrdLkiNsYrGs1LT',
            'CACHE_DRIVER'    => 'file',
            'SESSION_DRIVER'    => 'file',
            'QUEUE_DRIVER'    => 'database',
            'DB_CONNECTION'    => 'mysql',
            'DB_HOST'    => '127.0.0.1',
            'DB_DATABASE'    => 'seat',
            'DB_USERNAME'    => 'root',
            'DB_PASSWORD'    => '',
            'MAIL_DRIVER'       => 'mail',
            'MAIL_HOST'     => '127.0.0.1',
            'MAIL_FROM_NAME'     => 'admin@ineluctable.net',
            'MAIL_USERNAME'     => null,
            'MAIL_PASSWORD'     => null,
            'MAIL_PORT'         => 25,
            'MAIL_ENCRYPTION'   => null
        );

        $this->info('[+] Welcome to the SeAT v' . \Config::get('seat.version') . ' installer!');
        $this->line('');

        // The very first thing we will be checking is the existence of
        // the .env.php file which contains the configuration of a
        // installed system. If this file exists, we will assume
        // that SeAT is already installed and exit.
        if (\File::exists(base_path() . '/.installed.lck')) {

            $this->error('[!] It appears as if SeAT is already installed. Exiting.');
            return;
        }

        // Next, we will check that we will eventually be able to write
        // to the .env.php in base_path() /.env.php.
        if (!\File::isWritable(base_path() . '/.env')) {

            $this->error('[!] The installer needs to be able to write a configuration file to ' . base_path() . '/.env.php, but it appears as though it can not write there.');
            return;
        }

        // Knowing that we can write the configuration file, we move on to
        // getting the details for the database. We will try with the
        // defaults, and if that fails, continue to ask for details
        // until we can connect
        $this->info('[+] Database setup...');
        $this->info('[+] Please enter the details for the MySQL database to use (enter to use default):');
        $error_count = 0;
        while (true) {

            // Ask for the MySQL credentials.
            $configuration['DB_USERNAME'] = $this->ask('[?] Username (' . $configuration['DB_USERNAME'] .'):') ? : $configuration['DB_USERNAME'];
            $configuration['DB_PASSWORD'] = $this->secret('[?] Password:') ? : $configuration['DB_PASSWORD'];
            $configuration['DB_HOST'] = $this->ask('[?] Hostname (' . $configuration['DB_HOST'] .'):') ? : $configuration['DB_HOST'];
            $configuration['DB_DATABASE'] = $this->ask('[?] Database (' . $configuration['DB_DATABASE'] .'):') ? : $configuration['DB_DATABASE'];

            // Set the runtime configuration that we have
            \Config::set('database.connections.mysql.host', $configuration['DB_HOST']);
            \Config::set('database.connections.mysql.database', $configuration['DB_DATABASE']);
            \Config::set('database.connections.mysql.username', $configuration['DB_USERNAME']);
            \Config::set('database.connections.mysql.password', $configuration['DB_PASSWORD']);

            // Test the database connection
            try {

                \DB::reconnect();
                \DB::connection()->getDatabaseName();
                $this->info('[+] Successfully connected to the MySQL database.');
                $this->line('');

                // If the connection worked, we don't have to ask for anything
                // and just move on to the next section
                break;

            } catch (\Exception $e) {

                $error_count++;

                // Check if we have had more than 3 errors now.
                if($error_count >= 3) {

                    $this->error('[!] 3 attempts to connect to the database failed.');
                    $this->error('[!] Please ensure that you have a MySQL server with a database ready for SeAT to use before installation.');
                    return;
                }

                $this->error('[!] Unable to connect to the database with mysql://' . $configuration['mysql_username'] . '@' . $configuration['mysql_hostname'] . '/' . $configuration['mysql_database']);
                $this->error('[!] Please re-enter the configuration to try again.');
                $this->error('[!] MySQL said: ' .$e->getMessage());
                $this->line('');
                $this->info('[+] Please re-enter the MySQL details below:');
            }
        }

        // Now that we have a working database connection, move on to
        // the email configurations. If we have mail/sendmail as
        // the config, its easy. However, if we use SMTP, we
        // need to ask the user for credentials too, incase
        // those are needed. We will also start another
        // infinite loop to allow the user to confirm
        // that the details they entered is correct.
        $this->info('[+] Mail setup...');
        $this->info('[+] Please enter the details for the email configuration to use (enter to use default):');
        while (true) {

            // Ask for the email details
            $configuration['MAIL_DRIVER'] = $this->ask('[?] How are emails going to be sent? [mail/sendmail/smtp] (' . $configuration['MAIL_DRIVER'] .'):') ? : $configuration['MAIL_DRIVER'];

            // Check the option we got. If it is not in the array of
            // known configuration, we return to the question
            if (!in_array($configuration['MAIL_DRIVER'],  array('mail', 'sendmail', 'smtp'))) {

                $this->error('[!] The driver you have chosen is not recognized, please try again.');
                continue;

            }

            // Get the details about where emails will be coming from
            $configuration['MAIL_HOST'] = $this->ask('[?] Where will emails be coming from? (' . $configuration['MAIL_HOST'] .'):') ? : $configuration['MAIL_HOST'];
            $configuration['MAIL_FROM_NAME'] = $this->ask('[?] Who will emails be coming from? (' . $configuration['MAIL_FROM_NAME'] .'):') ? : $configuration['MAIL_FROM_NAME'];

            // If the configuration option is set as smtp, we need to
            // give the option to set the username and password
            if ($configuration['MAIL_DRIVER'] == 'smtp') {

                $configuration['MAIL_HOST'] = $this->ask('[?] SMTP Hostname (' . $configuration['MAIL_HOST'] .'):') ? : $configuration['MAIL_HOST'];
                $configuration['MAIL_USERNAME'] = $this->ask('[?] SMTP Username (' . $configuration['MAIL_USERNAME'] .'):') ? : $configuration['MAIL_USERNAME'];
                $configuration['MAIL_PASSWORD'] = $this->secret('[?] SMTP Password:') ? : $configuration['MAIL_PASSWORD'];
                $configuration['MAIL_PORT'] = $this->ask('[?] SMTP Port (' . $configuration['MAIL_PORT'] . '):') ? : $configuration['MAIL_PORT'];
                $configuration['MAIL_ENCRYPTION'] = $this->ask('[?] SMTP Encryption (' . $configuration['MAIL_ENCRYPTION'] . '):') ? : $configuration['MAIL_ENCRYPTION'];
            }

            // Print the values and get confirmation that they are correct
            $this->line('');
            $this->line('[+] Mail configuration summary:');
            $this->line('[+]    Mail Driver: ' . $configuration['MAIL_DRIVER']);

            // If we are going to be using the SMTP driver, show the
            // values for the host/user/pass
            if ($configuration['MAIL_DRIVER'] == 'smtp') {

                $this->line('[+]    SMTP Host: ' . $configuration['MAIL_HOST']);
                $this->line('[+]    SMTP Username: ' . $configuration['MAIL_USERNAME']);
                $this->line('[+]    SMTP Password: ' . str_repeat('*', strlen($configuration['MAIL_PASSWORD'])));
                $this->line('[+]    SMTP Port: ' . $configuration['MAIL_PORT']);
                $this->line('[+]    SMTP Encryption: ' . $configuration['MAIL_ENCRYPTION']);
            }
            $this->line('');


            if ($this->confirm('[?] Are the above mail settings correct? [yes/no]', true))
                break;
            else
                continue;
        }

        // With the configuration done, lets attempt to write this to
        // to disk
        if (!$this->writeConfig($configuration)) {

            $this->error('[!] Writing the configuration file failed!');
            return;
        }

        $this->info('[+] Successfully wrote the configuration file');

        // With configuration in place, lets move on to preparing SeAT
        // for use. We have to do a few things for which most
        // already have commands. So, lets re-use those
        // meaning that if they change the intaller
        // is already up to date.

        // setup database for migrations
        $this->info('[+] Setting up the database for  migrations...');
        $this->call('migrate:install');

        // Run the database migrations
        $this->info('[+] Running the database migrations...');
        $this->call('migrate');

        // Run the database seeds
        $this->info('[+] Running the database seeds...');
        $this->call('db:seed');

        // Update the SDEs
        $this->info('[+] Updating to the latest EVE SDE\'s...');
        $this->call('seat:update-sde', array('--confirm' => null));

        // Configure the admin user
        $this->info('[+] Configuring the \'admin\' user...');
        $this->call('seat:reset');

        // Sync the access groups
        $this->info('[+] Syncing the access groups...');
        $this->call('seat:groupsync');
        $this->line('');

        // Regenerate the Application Encryption key
        $this->info('[+] Regenerating the Encryption Key');
        $this->call('key:generate');
        $this->line('');

        // Finally, write the installer lock file!
        $lock_file_write = \File::put(base_path() . '/.installed.lck', 'Installed ' . date('Y-m-d H:i:s'));

        // Check that we wrote the lock file successfully
        if (!$lock_file_write)
            $this->error('[!] Was not able to write the installation lock file! Please touch \'installed.lck\'.');

        $this->info('[+] Done!');
    }
}
