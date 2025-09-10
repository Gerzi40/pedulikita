<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCreated extends Notification
{
    use Queueable;

    public string $organization_name;
    public string $event_name;
    public string $event_id;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $organization_name, string $event_name, int $event_id)
    {
        $this->organization_name = $organization_name;
        $this->event_name = $event_name;
        $this->event_id = $event_id;
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
            'title' => "Pengajuan acara baru",
            'content' => "Organisasi {$this->organization_name} telah mengajukan acara {$this->event_name} dan menunggu persetujuan.",
            'id' => $this->event_id
        ];
    }
}
