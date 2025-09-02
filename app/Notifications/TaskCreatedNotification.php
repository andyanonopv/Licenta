<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
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
            ->subject('New Task Created: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new task has been created in the project: ' . $this->task->project->name)
            ->line('Task Details:')
            ->line('Title: ' . $this->task->title)
            ->line('Description: ' . ($this->task->description ?: 'No description provided'))
            ->line('Priority: ' . ucfirst($this->task->priority))
            ->line('Due Date: ' . ($this->task->due_date ? $this->task->due_date->format('M d, Y') : 'No due date set'))
            ->line('Assigned to: ' . $this->task->user->name)
            ->action('View Task', url('/projects/' . $this->task->project_id . '/tasks'))
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
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'project_name' => $this->task->project->name,
            'assigned_user' => $this->task->user->name,
            'priority' => $this->task->priority,
            'due_date' => $this->task->due_date,
        ];
    }
}