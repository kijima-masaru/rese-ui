<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail; //予約当日のメール用のインポート
use App\Mail\ReservationReminderMail; //メールの Mailable クラスをインポート

class ReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reserve;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reserve)
    {
        $this->reserve = $reserve;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $userEmail = $this->reserve->user->email;

        // リマインダーメールを送信
        Mail::to($userEmail)->send(new ReservationReminderMail($this->reserve));
    }
}
