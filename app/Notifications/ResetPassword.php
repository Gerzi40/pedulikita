<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    public $token;
    
    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $count = config('auth.passwords.'.config('auth.defaults.passwords').'.expire');

        $app_name = config('app.name');

        return (new MailMessage)
            ->subject('Permintaan Atur Ulang Kata Sandi')
            ->greeting('Halo!')
            ->line('Anda menerima email ini karena kami menerima permintaan untuk mengatur ulang kata sandi akun Anda.')
            ->action('Atur Ulang Sandi', $url)
            ->line("Tautan untuk mengatur ulang kata sandi ini akan kedaluwarsa dalam {$count} menit.")
            ->line('Jika Anda tidak merasa meminta pengaturan ulang kata sandi, Anda tidak perlu melakukan tindakan apa pun.')
            ->salutation("Salam, {$app_name}");
    }
}
