<?php

namespace ineluctable\Http\Controllers;

use Illuminate\Http\Request;

use ineluctable\Http\Requests;
use ineluctable\Http\Controllers\Controller;
use ineluctable\Jobs\UpdateEveCharacters;

class apicontroller extends Controller
{
    public function UpdateCharacters()
    {
        $job = new UpdateEveCharacters();

        $this->dispatch($job);

        return 'Characters updated';
    }
}
