<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserve; // Reserve モデルをインポート
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationReminder; // リマインダーメールのメールクラスをインポート

class SendReservationReminder extends Command
{
    protected $signature = 'reservation:reminder';
    protected $description = 'Send reservation reminders';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $reservations = Reserve::where('status', 'before')
            ->whereDate('day', now())
            ->get();

        foreach ($reservations as $reservation) {
            $user = User::find($reservation->user_id);
            $email = $user->email;
        }

        Mail::to($email)->send(new ReservationReminderMail($reservation));
    }
}