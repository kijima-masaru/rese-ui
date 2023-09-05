<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendReservationReminder;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendReservationReminder::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // 朝9:00にSendReservationReminderコマンドを実行する
        $schedule->command('reservation:reminder')->dailyAt('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

