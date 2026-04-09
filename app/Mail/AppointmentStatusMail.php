<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $status;

    /**
     * Create a new message instance.
     */
    public function __construct($appointment, $status)
    {
        $this->appointment = $appointment;
        $this->status = $status;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = $this->getSubject();
        
        return $this->subject($subject)
                    ->view('emails.appointment-status')
                    ->with([
                        'appointment' => $this->appointment,
                        'status' => $this->status,
                    ]);
    }

    /**
     * Get email subject based on status
     */
    private function getSubject()
    {
        switch ($this->status) {
            case 'confirmed':
                return '✅ تم تأكيد موعدك - المحافظة العقارية';
            case 'cancelled':
                return '❌ تم إلغاء موعدك - المحافظة العقارية';
            case 'completed':
                return '✅ تم إنجاز موعدك - المحافظة العقارية';
            default:
                return '📅 تحديث حالة موعدك - المحافظة العقارية';
        }
    }
}