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

        foreach ($reservations as $reservation) {
            // メールを送信するコードを記述
            Mail::to($reservation->user->email)->send(new ReservationReminderMail($reservation));
        }

        $this->info('Reservation reminders sent successfully.');
    }
}