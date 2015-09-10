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

use ineluctable\EveApi\BaseApi;
use Pheal\Pheal;

class SeatDiagnose extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seat:diagnose';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs Diagnostic checks to aid in debugging.';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {

        // Start by printing some information about what the version
        $this->info('Running SeAT ' . \Config::get('seat.version') . ' Diagnostics');
        $this->line('');

        // It is important to run the command as the user that the workers are running as.
        // This way, the checks that ensure file permissions are right are executed
        // properly. If this is not the case, notify the user

        $this->comment('If you are not already doing so, it is recommended that you run this as the user the workers are running as.');
        $this->comment('Eg: `sudo -u apache php artisan seat:diagnose`.');
        $this->comment('This helps to check whether the permissions are correct.');
        $this->line('');

        // Go ahead and get the configuration information using
        // the \Config helper and print that
        $this->info('SeAT configuration:');
        if (\Config::get('app.debug'))
            $this->comment('[warning] Debug Mode On: Yes. It is recommended that you set this to false in evn file - APP_DEBUG=false');
        else
            $this->line('[ok] Debug Mode On: No');
        $this->line('Url: ' . \Config::get('app.url'));
        $this->line('Failed API limit: ' . \Config::get('seat.ban_limit'));
        $this->line('Ban count time: ' . \Config::get('seat.ban_grace') . ' minutes');
        $this->line('');

        // Check that the log files are writable
        $this->info('Logging:');
        if (is_writable(storage_path() . '/logs/laravel.log'))
            $this->line('[ok] ' . storage_path() . '/logs/laravel.log is writable.');
        else
            $this->error('[error] ' . storage_path() . '/logs/laravel.log is not writable.');
        $this->line('');

        // Grab the database configurations from the config,
        // obviously hashing out the password
        $this->info('Database configuration:');
        $this->line('Database driver: ' . \Config::get('database.default'));
        $this->line('MySQL Host: ' . \Config::get('database.connections.mysql.host'));
        $this->line('MySQL Database: ' . \Config::get('database.connections.mysql.database'));
        $this->line('MySQL Username: ' . \Config::get('database.connections.mysql.username'));
        $this->line('MySQL Password: ' . str_repeat('*', strlen(\Config::get('database.connections.mysql.password'))));
        $this->line('');

        // Test the database connection. An exception will be
        // thrown if this fails, so we can catch it and
        // warn accordingly
        $this->info('Database connection test...');
        try {

            $this->line('[ok] Successfully connected to database `' . \DB::connection()->getDatabaseName() . '` (did not test schema)');

        } catch (\Exception $e) {

            $this->error('[error] Unable to obtain a MySQL connection. The error was: ' . $e->getCode() . ': ' . $e->getMessage());
        }
        $this->line('');

      // Testing Pheal
        $this->info('EVE API call test with phealng...');

        // Bootstrap a new Pheal instance for use
        BaseApi::bootstrap();
        $pheal = new Pheal();

        // Test that Pheal usage is possible by calling the
        // ServerStatus() API
        try {

            $server_status = $pheal->serverScope->ServerStatus();
            $this->line('[ok] Testing the ServerStatus API call returned a response reporting ' . $server_status->onlinePlayers . ' online players, with the result cache expiring ' . \Carbon\Carbon::parse($server_status->cached_until)->diffForHumans());

        } catch (\Exception $e) {

            $this->error('[error] API Call test failed. The last error was: ' . $e->getCode() . ': ' . $e->getMessage());
        }
        $this->line('');

    }
}
