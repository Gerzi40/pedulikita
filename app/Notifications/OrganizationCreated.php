<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrganizationCreated extends Notification
{
    use Queueable;

    public string $organization_name;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $organization_name)
    {
        $this->organization_name = $organization_name;
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

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => "Pengajuan organisasi baru",
            'content' => "Organisasi bernana {$this->organization_name} telah dibuat dan sedang menunggu persetujuan."
        ];
    }
}
