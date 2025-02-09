<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class SalesProjectUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable)
    {
        return ['database'];
    }

    protected $project;

    public function __construct($project)
    {
        $this->project = $project;
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
    public function toArray(object $notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->project_name,
            'status' => $this->project->status,
            'message' => "มีการอัปเดตโปรเจค: {$this->project->project_name}"
        ];
    }
}
