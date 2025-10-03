<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventRejected extends Notification
{
    use Queueable;

    public string $event_name;
    public string $reason;
    public string $event_id;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $event_name, string $reason, string $event_id)
    {
        $this->event_name = $event_name;
        $this->reason = $reason;
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
            'title' => "Acara Anda tidak disetujui",
            'content' => "Mohon maaf, acara {$this->event_name} yang Anda ajukan tidak disetujui oleh admin.
                Alasan: {$this->reason}
                Silakan perbaiki dan ajukan kembali jika diperlukan.",
            'route' => 'organization.events.show',
            'id' => $this->event_id
        ];
    }
}
