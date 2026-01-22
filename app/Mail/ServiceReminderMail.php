<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ServiceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    // Variabel publik agar bisa diakses langsung di dalam View (Blade)
    public $user;
    public $kendaraan;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $kendaraan)
    {
        // Menyimpan data yang diterima saat class ini dipanggil ke dalam properti class
        $this->user = $user;
        $this->kendaraan = $kendaraan;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Mengatur Subjek Email yang akan muncul di inbox penerima
        return new Envelope(
            subject: 'Pengingat Servis Berkala - Kings Bengkel Mobil',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Menentukan file View (blade) mana yang akan dijadikan isi email
        return new Content(
            view: 'emails.service_reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
