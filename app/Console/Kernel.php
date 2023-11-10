<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    $schedule->command('leaves:escalation-task')
             ->hourly(); // Adjust the time as needed

    $schedule->command('leaves:leave_revok_escalation')
             ->everyMinute(); // Adjust the time as needed
    $schedule->command('leaves:annual_remaining_brought_foward')
             ->yearly(); // Adjust the time as needed

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $commands = [
        // Other commands...
        Commands\LeavesEscalationTask::class,
        Commands\LeaveRevokEsalationTask::class,

    ];

}
