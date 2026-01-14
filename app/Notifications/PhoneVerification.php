<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PhoneVerification extends Notification
{
    use Queueable;

    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Kode Verifikasi Ganti Nomor HP')
                    ->line('Kami menerima permintaan untuk mengubah nomor HP pada akun Anda.')
                    ->line('Gunakan kode berikut untuk melakukan verifikasi:')
                    ->line($this->code)
                    ->line('Jika Anda tidak melakukan permintaan ini, abaikan saja email ini.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
