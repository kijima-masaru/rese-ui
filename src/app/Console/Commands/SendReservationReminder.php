<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserve;
use App\Mail\ReservationReminderMail;
use Illuminate\Support\Facades\Mail;

class SendReservationReminder extends Command
{
    protected $signature = 'reservation:reminder';
    protected $description = 'Send reservation reminders';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
{
    $reservations = Reserve::whereDate('day', now())->where('status', 'before')->get();

    // デバッグログを出力
    foreach ($reservations as $reservation) {
        $this->info('Processing reservation ID: ' . $reservation->id);

        // メールを送信するコードを記述
        $this->info('Sending email to: ' . $reservation->user->email);
        Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
    }

    $this->info('Reservation reminders sent successfully.');
}

}