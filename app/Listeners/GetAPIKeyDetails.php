<?php

namespace ineluctable\Listeners;

use ineluctable\EveApi\Account\AccountStatus;
use ineluctable\EveApi\Account\APIKeyInfo;
use ineluctable\EveApi\Eve\CharacterInfo;
use ineluctable\Events\APIKeyAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GetAPIKeyDetails
{
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
        AccountStatus::Update($event->SeatKey->keyID, $event->SeatKey->vCode );
        APIKeyInfo::Update($event->SeatKey->keyID, $event->SeatKey->vCode);
    }
}
