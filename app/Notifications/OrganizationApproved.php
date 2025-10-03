<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizationApproved extends Notification
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
        $url = url(route('login', [], false));

        $app_name = config('app.name');

        return (new MailMessage)
            ->subject('Akun Anda Telah Disetujui')
            ->greeting('Halo!')
            ->line('Selamat! Akun Anda telah berhasil disetujui dan sekarang sudah aktif.')
            ->line('Anda dapat masuk ke aplikasi dengan menggunakan email dan kata sandi yang sudah Anda daftarkan.')
            ->action('Masuk Sekarang', $url)
            ->line('Jika Anda tidak merasa membuat akun, abaikan email ini.')
            ->salutation("Salam, {$app_name}");
    }
}
