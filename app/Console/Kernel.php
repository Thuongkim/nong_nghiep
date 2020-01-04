<?php

namespace App\Console;

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
        'App\Console\Commands\RemindAccess',
        'App\Console\Commands\RemindProcessingNews',
        'App\Console\Commands\RemindReceiveHubLink',
        'App\Console\Commands\CollaboratorNewsReportMonthly',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('report_monthly:collaborator_news')->monthlyOn(1, '07:00');
        $schedule->command('remind:receive_hublink')->dailyAt('07:30');
        $schedule->command('remind:processing_news')->dailyAt('07:45');
        $schedule->command('remind:access')->dailyAt('12:15');//twiceDaily(8, 14);
        // $schedule->command('inspire')
        //          ->hourly();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
