<?php // タスクスケジューラーの予約当日のリマインダーメール用

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserve; // Reserveモデルをインポート

class ReservationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reserve $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('予約リマインダー')
                    ->view('emails.reservation-reminder')
                    ->with([
                        'reservation' => $this->reservation,
                    ]);
    }
}
