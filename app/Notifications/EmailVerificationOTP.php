<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerificationOTP extends Notification
{
    use Queueable;

    protected $otp;

    /**
     * Create a new notification instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Kode Verifikasi Email Anda')
                    ->greeting('Halo, ' . $notifiable->nama . '!')
                    ->line('Terima kasih telah mendaftar. Gunakan kode verifikasi di bawah ini untuk mengaktifkan akun Anda:')
                    ->line($this->otp)
                    ->line('Kode ini berlaku selama 10 menit.')
                    ->line('Jika Anda tidak merasa melakukan pendaftaran, abaikan saja email ini.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
