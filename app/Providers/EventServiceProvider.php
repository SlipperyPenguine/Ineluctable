<?php

namespace ineluctable\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'ineluctable\Events\APIKeyAdded' => [
            'ineluctable\Listeners\GetAPIKeyDetails',
            'ineluctable\Listeners\GetDetailsForAnApiKey'
        ],
        'ineluctable\Events\JobScheduleUpdateAccountCharactersCompleted' => [
            'ineluctable\Listeners\JobCompleteListener@LogJobScheduleUpdateAccountCharactersCompleted'
        ],
        'ineluctable\Events\ScheduleUpdateEveCharactersCompleted' => [
            'ineluctable\Listeners\JobCompleteListener@LogScheduleUpdateEveCharactersCompleted'
        ],
        'ineluctable\Events\ScheduleUpdateEveDataCompleted' => [
            'ineluctable\Listeners\JobCompleteListener@LogScheduleUpdateEveDataCompleted'
        ],
        'ineluctable\Events\ScheduleUpdateEveMapCompleted' => [
            'ineluctable\Listeners\JobCompleteListener@LogScheduleUpdateEveMapCompleted'
        ],
        'ineluctable\Events\ScheduleUpdateEveServerCompleted' => [
            'ineluctable\Listeners\JobCompleteListener@LogScheduleUpdateEveServerCompleted'
        ],
        'ineluctable\Events\ScheduleUpdateCorporationCompleted' => [
            'ineluctable\Listeners\JobCompleteListener@LogScheduleUpdateCorporationCompleted'
        ]
    ];


    //ScheduleUpdateCorporationCompleted

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
