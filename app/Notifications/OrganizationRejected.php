<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizationRejected extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $app_name = config('app.name');

        return (new MailMessage)
            ->subject('Akun Anda Tidak Disetujui')
            ->greeting('Halo!')
            ->line('Terima kasih telah mendaftar. Namun, setelah melalui proses verifikasi, permohonan akun Anda belum dapat kami setujui.')
            ->line('Apabila Anda merasa ada kekeliruan atau ingin mencoba kembali, silakan hubungi tim kami untuk informasi lebih lanjut.')
            ->line('Kami menghargai ketertarikan Anda untuk menggunakan layanan kami.')
            ->salutation("Salam, {$app_name}");
    }
}
