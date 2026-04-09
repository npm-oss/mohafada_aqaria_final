<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LandRegisterStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $register;
    public $status;

    public function __construct($register, $status)
    {
        $this->register = $register;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status === 'approved'
            ? '✅ تم قبول طلب الدفتر العقاري'
            : '❌ تم رفض طلب الدفتر العقاري';

        return $this->subject($subject)
            ->view('emails.land-register-status')
            ->with([
                'register' => $this->register,
                'status' => $this->status
            ]);
    }
}