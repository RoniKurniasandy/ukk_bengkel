<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     * 
     * @param array $data ['title', 'message', 'url', 'icon', 'type']
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Always to DB, and selectively to Mail if needed (optional)
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($this->data['title'])
                    ->greeting('Halo, ' . $notifiable->nama . '!')
                    ->line($this->data['message'])
                    ->action('Lihat Detail', url($this->data['url']))
                    ->line('Terima kasih telah menggunakan layanan Kings Bengkel Mobil!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->data['title'],
            'message' => $this->data['message'],
            'url' => $this->data['url'] ?? '#',
            'icon' => $this->data['icon'] ?? 'bi-info-circle',
            'type' => $this->data['type'] ?? 'info', // success, danger, warning, info
        ];
    }
}
