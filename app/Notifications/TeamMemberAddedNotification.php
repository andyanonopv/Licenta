<?php

namespace App\Notifications;

use App\Models\Project;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberAddedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $newMember;

    /**
     * Create a new notification instance.
     */
    public function __construct(Project $project, User $newMember)
    {
        $this->project = $project;
        $this->newMember = $newMember;
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
        return (new MailMessage)
            ->subject('New Team Member Added to Project: ' . $this->project->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new team member has been added to the project: ' . $this->project->name)
            ->line('New team member: ' . $this->newMember->name . ' (' . $this->newMember->email . ')')
            ->line('Project Description: ' . ($this->project->description ?: 'No description provided'))
            ->action('View Project', url('/projects/' . $this->project->id))
            ->line('You will now receive notifications for tasks created or modified in this project.')
            ->line('Thank you for using our project management system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'project_id' => $this->project->id,
            'project_name' => $this->project->name,
            'new_member_name' => $this->newMember->name,
            'new_member_email' => $this->newMember->email,
        ];
    }
}