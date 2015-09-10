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

use ineluctable\models\SeatKey;
use ineluctable\models\EveAccountAPIKeyInfoCharacters;

class SeatAPIFindSickKeys extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'seat:find-sick-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show keys which are disabled due to API Authentication errors.';

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

        $this->info('Finding keys that are not ok.');

        // Search the database for keys that are marked as disabled
        foreach (SeatKey::where('isOk', '=', 0)->get() as $key) {

            $this->comment('Key ' . $key->keyID . ' is not ok.');
            $this->line('Characters on this key:');

            // Print the characters on the affected key
            foreach (EveAccountAPIKeyInfoCharacters::where('keyID', '=', $key->keyID)->get() as $character)
                $this->line('   ' . $character->characterName);
        }
    }
}
