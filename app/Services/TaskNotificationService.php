<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Project;
use App\Notifications\TaskCreatedNotification;
use App\Notifications\TaskUpdatedNotification;
use Illuminate\Support\Facades\Notification;

class TaskNotificationService
{
    /**
     * Send notifications when a task is created
     */
    public function notifyTaskCreated(Task $task)
    {
        $project = $task->project;
        
        // Get all team members of the project (excluding the task creator)
        $teamMembers = $project->users()->where('users.id', '!=', $task->user_id)->get();
        
        // Send notification to all team members
        if ($teamMembers->isNotEmpty()) {
            Notification::send($teamMembers, new TaskCreatedNotification($task));
        }
        
        // Also notify the assigned user if they're not the creator
        if ($task->user_id !== auth()->id()) {
            $task->user->notify(new TaskCreatedNotification($task));
        }
    }

    /**
     * Send notifications when a task is updated
     */
    public function notifyTaskUpdated(Task $task, array $originalData = [])
    {
        $project = $task->project;
        
        // Track changes
        $changes = $this->getTaskChanges($task, $originalData);
        
        // Get all team members of the project (excluding the person who made the update)
        $teamMembers = $project->users()->where('users.id', '!=', auth()->id())->get();
        
        // Send notification to all team members
        if ($teamMembers->isNotEmpty()) {
            Notification::send($teamMembers, new TaskUpdatedNotification($task, $changes));
        }
        
        // Also notify the assigned user if they're not the one who made the update
        if ($task->user_id !== auth()->id()) {
            $task->user->notify(new TaskUpdatedNotification($task, $changes));
        }
    }

    /**
     * Get the changes made to a task
     */
    private function getTaskChanges(Task $task, array $originalData): array
    {
        $changes = [];
        
        $fieldsToTrack = ['title', 'description', 'priority', 'status', 'due_date'];
        
        foreach ($fieldsToTrack as $field) {
            if (isset($originalData[$field]) && $originalData[$field] != $task->$field) {
                $oldValue = $originalData[$field];
                $newValue = $task->$field;
                
                // Format dates
                if ($field === 'due_date') {
                    $oldValue = $oldValue ? \Carbon\Carbon::parse($oldValue)->format('M d, Y') : 'No due date';
                    $newValue = $newValue ? $newValue->format('M d, Y') : 'No due date';
                }
                
                // Format status and priority
                if (in_array($field, ['status', 'priority'])) {
                    $oldValue = ucfirst(str_replace('_', ' ', $oldValue));
                    $newValue = ucfirst(str_replace('_', ' ', $newValue));
                }
                
                $changes[$field] = [
                    'old' => $oldValue,
                    'new' => $newValue
                ];
            }
        }
        
        return $changes;
    }

    /**
     * Send notification when a team member is added to a project
     */
    public function notifyTeamMemberAdded(Project $project, $newMember)
    {
        // Get all existing team members
        $existingMembers = $project->users()->where('users.id', '!=', $newMember->id)->get();
        
        if ($existingMembers->isNotEmpty()) {
            // Create a simple notification for new team member
            $notification = new \App\Notifications\TeamMemberAddedNotification($project, $newMember);
            Notification::send($existingMembers, $notification);
        }
    }
}