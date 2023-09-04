<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // 他のコマンド
        \App\Console\Commands\SendReservationEmails::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // 予約リマインダーを毎日9:00に送信
        $schedule->command('email:send-reservation-reminders')
                ->dailyAt('09:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

