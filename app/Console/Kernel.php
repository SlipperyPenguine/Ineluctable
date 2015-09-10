<?php

namespace ineluctable\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \ineluctable\Console\Commands\SeatAddKey::class,
        \ineluctable\Console\Commands\SeatReset::class,
        \ineluctable\Console\Commands\SeatAPIUpdate::class,
        \ineluctable\Console\Commands\SeatQueueStatus::class,
        \ineluctable\Console\Commands\SeatAPIFindKeyByName::class,
        \ineluctable\Console\Commands\SeatAPIFindNameByKey::class,
        \ineluctable\Console\Commands\SeatAPIFindSickKeys::class,
        \ineluctable\Console\Commands\SeatAPIDeleteKey::class,
        \ineluctable\Console\Commands\SeatVersion::class,
        \ineluctable\Console\Commands\SeatDiagnose::class,
        \ineluctable\Console\Commands\SeatGroupSync::class,
        \ineluctable\Console\Commands\SeatClearCache::class,
        \ineluctable\Console\Commands\SeatUpdateSDE::class,
        \ineluctable\Console\Commands\SeatInstall::class,
        \ineluctable\Console\Commands\SeatUpdate::class,
        \ineluctable\Console\Commands\SeatUserMigrate::class,

        \ineluctable\Console\Commands\scheduled\EveCharacterUpdater::class,
        \ineluctable\Console\Commands\scheduled\EveCorporationAssetsUpdater::class,
        \ineluctable\Console\Commands\scheduled\EveCorporationWalletUpdater::class,
        \ineluctable\Console\Commands\scheduled\EveCorporationUpdater::class,
        \ineluctable\Console\Commands\scheduled\EveEveUpdater::class,
        \ineluctable\Console\Commands\scheduled\EveMapUpdater::class,
        \ineluctable\Console\Commands\scheduled\EveServerUpdater::class,
        \ineluctable\Console\Commands\scheduled\SeatQueueCleanup::class,
        \ineluctable\Console\Commands\scheduled\SeatNotify::class

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('seatscheduled:api-update-all-characters')->hourly();
        $schedule->command('seatscheduled:api-update-all-corporations')->hourly();
        $schedule->command('seatscheduled:api-update-eve')->daily();
        $schedule->command('seatscheduled:api-update-map')->hourly();
        $schedule->command('seatscheduled:api-update-server')->everyFiveMinutes();

    }
}
