<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserve;
use App\Mail\ReservationReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendReservationEmails extends Command
{
    protected $signature = 'email:send-reservation-reminders';

    protected $description = 'Send reservation reminder emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $reservations = Reserve::where('status', 'before')
            ->whereDate('day', Carbon::today())
            ->with('user')
            ->get();

        foreach ($reservations as $reservation) {
            $userEmail = $reservation->user->email;
            Mail::to($userEmail)->send(new ReservationReminderMail($reservation));
        }

        $this->info('Reservation reminder emails sent successfully!');
    }
}
