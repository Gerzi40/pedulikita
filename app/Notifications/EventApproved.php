<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventApproved extends Notification
{
    use Queueable;

    public string $event_name;
    public string $event_point;
    public string $event_id;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $event_name, string $event_point, string $event_id)
    {
        $this->event_name = $event_name;
        $this->event_point = $event_point;
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
            'title' => "Acara Anda disetujui",
            'content' => "Acara {$this->event_name} yang Anda ajukan telah disetujui dan Anda mendapatkan {$this->event_point} poin. Terima kasih atas kontribusi Anda!",
            'route' => 'organization.events.show',
            'id' => $this->event_id
        ];
    }
}
