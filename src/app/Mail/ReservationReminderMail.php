<?php // タスクスケジューラーの予約当日のリマインダーメール用

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserve;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reserve)
    {
        $this->reserve = $reserve;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('予約リマインダー')
                    ->view('emails.reservation-reminder');
    }
}
