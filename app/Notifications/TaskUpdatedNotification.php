<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $changes;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task, array $changes = [])
    {
        $this->task = $task;
        $this->changes = $changes;
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
        $mailMessage = (new MailMessage)
            ->subject('Task Updated: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A task has been updated in the project: ' . $this->task->project->name)
            ->line('Task: ' . $this->task->title);

        // Show what changed
        if (!empty($this->changes)) {
            $mailMessage->line('Changes made:');
            foreach ($this->changes as $field => $change) {
                $mailMessage->line(ucfirst(str_replace('_', ' ', $field)) . ': ' . $change['old'] . ' → ' . $change['new']);
            }
        }

        $mailMessage
            ->line('Current Task Details:')
            ->line('Description: ' . ($this->task->description ?: 'No description provided'))
            ->line('Priority: ' . ucfirst($this->task->priority))
            ->line('Status: ' . ucfirst(str_replace('_', ' ', $this->task->status)))
            ->line('Due Date: ' . ($this->task->due_date ? $this->task->due_date->format('M d, Y') : 'No due date set'))
            ->line('Assigned to: ' . $this->task->user->name)
            ->action('View Task', url('/projects/' . $this->task->project_id . '/tasks'))
            ->line('Thank you for using our project management system!');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_name' => $this->task->project->name,
            'assigned_user' => $this->task->user->name,
            'changes' => $this->changes,
            'updated_at' => $this->task->updated_at,
        ];
    }
}