<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ReminderJob; //タスクスケジューラー用のインポート
use Illuminate\Support\Facades\DB; //タスクスケジューラー用のインポート

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
        $schedule->call(function () {
        // 予約当日の朝にリマインダーを送信する処理を実装
        $today = now()->format('Y-m-d');
        $reservations = DB::table('reserves')
            ->whereDate('day', $today)
            ->where('status', 'before') // 'before' の予約のみを対象にする
            ->get();

        foreach ($reservations as $reservation) {
            dispatch(new ReminderJob($reservation->user_id));
        }
    })->dailyAt('09:00');
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
}
