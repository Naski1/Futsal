<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PemesananNotification extends Notification
{
    use Queueable;

    public $pemesanan;

    /**
     * Create a new notification instance.
     */
    public function __construct($pemesanan)
    {
        $this->pemesanan = $pemesanan;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $formatDate = Carbon::parse($this->pemesanan['tgl_pesan'])->format('d F Y');
        // $pesan = '';
        if ($this->pemesanan['status'] == 'baru') {
            $pesan = 'Pemesanan baru pada ' . $this->pemesanan['lapangan'] . ' oleh ' . $this->pemesanan['costumer'] . ', tanggal ' . $formatDate;
        }

        if ($this->pemesanan['status'] == 'selesai') {
            $pesan = 'Pemesanan pada ' . $this->pemesanan['lapangan'] . ' oleh ' . $this->pemesanan['costumer'] . ', tanggal ' . $formatDate . ' sudah selesai';
        }

        return [
            'id' => $this->pemesanan['id'],
            'data' => $pesan,
            'status' => $this->pemesanan['status']
        ];
        // return [];
    }
}
