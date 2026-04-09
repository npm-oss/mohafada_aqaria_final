<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $status;
    public $userName;
    public $adminNotes;

    public function __construct(Appointment $appointment, $status, $userName = 'العميل الكريم', $adminNotes = null)
    {
        $this->appointment = $appointment;
        $this->status = $status;
        $this->userName = $userName;
        $this->adminNotes = $adminNotes;
    }

    public function build()
    {
        $subject = '';
        
        switch($this->status) {
            case 'confirmed':
                $subject = '✅ تم تأكيد موعدك - المحافظة العقارية';
                break;
            case 'cancelled':
                $subject = '❌ تم إلغاء موعدك - المحافظة العقارية';
                break;
            case 'completed':
                $subject = '✓ تم إتمام موعدك - المحافظة العقارية';
                break;
            default:
                $subject = '📅 تحديث حالة موعدك - المحافظة العقارية';
        }

        return $this->subject($subject)
                    ->view('emails.appointment-status');
    }
}