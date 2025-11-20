<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEvent extends Notification
{
    use Queueable;

    public string $organization_name;
    public string $event_id;

    public function __construct(string $organization_name, string $event_id)
    {
        $this->organization_name = $organization_name;
        $this->event_id = $event_id;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => "Acara baru",
            'content' => "{$this->organization_name} baru saja mengumumkan acara baru. Ayo daftar sekarang!",
            'route' => 'volunteer.events.show',
            'id' => $this->event_id
        ];
    }
}
