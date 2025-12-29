<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\User;

class SendSubadminOtpNotification extends Notification
{
    use Queueable;

    public $otp;
    public $subadmin;

    public function __construct($otp, $subadmin)
    {
        $this->otp = $otp;
        $this->subadmin = $subadmin;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('OTP for Subadmin Login')
            ->line('Subadmin: ' . $this->subadmin->email . ' is trying to log in.')
            ->line('OTP: **' . $this->otp . '**')
            ->line('This OTP will expire in 5 minutes.');
    }
}
