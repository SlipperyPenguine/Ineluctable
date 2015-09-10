<?php

namespace ineluctable\Listeners;

use Illuminate\Foundation\Bus\DispatchesJobs;

use ineluctable\EveApi\Character\Info;
use ineluctable\Events\APIKeyAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use ineluctable\Jobs\UpdateAccountCharacters;
use ineluctable\Jobs\UpdateCorporationAccount;

class GetDetailsForAnApiKey implements ShouldQueue
{
    use DispatchesJobs;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  APIKeyAdded  $event
     * @return void
     */
    public function handle(APIKeyAdded $event)
    {
        // Update character info
        Info::Update($event->SeatKey->keyID, $event->SeatKey->vCode);

        $access = \ineluctable\EveApi\BaseApi::determineAccess($event->SeatKey->keyID);
        // Based in the key type, push a update job
        switch ($access['type']) {
            case 'Character':

            //queue a job to get all the character info
                $job = new UpdateAccountCharacters($event->SeatKey->keyID, $event->SeatKey->vCode);
                $this->dispatch($job);
                break;

            case 'Corporation':

                //queue a job to get all the character info
                $job = new UpdateCorporationAccount($event->SeatKey->keyID, $event->SeatKey->vCode);
                $this->dispatch($job);
                break;

                break;

            default:
                break;
        }



    }
}
