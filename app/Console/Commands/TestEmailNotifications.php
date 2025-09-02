<?php

namespace App\Console\Commands;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskNotificationService;
use Illuminate\Console\Command;

class TestEmailNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:email-notifications {--user-id=} {--project-id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test email notifications by sending sample notifications';

    /**
     * Execute the console command.
     */
    public function handle(TaskNotificationService $notificationService)
    {
        $userId = $this->option('user-id');
        $projectId = $this->option('project-id');

        if (!$userId || !$projectId) {
            $this->error('Please provide both --user-id and --project-id options');
            return 1;
        }

        $user = User::find($userId);
        $project = Project::find($projectId);

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        if (!$project) {
            $this->error('Project not found');
            return 1;
        }

        $this->info('Testing email notifications...');

        // Test task creation notification
        $this->info('1. Testing task creation notification...');
        $task = new Task([
            'user_id' => $user->id,
            'project_id' => $project->id,
            'title' => 'Test Task - ' . now()->format('Y-m-d H:i:s'),
            'description' => 'This is a test task created to verify email notifications are working.',
            'priority' => 'high',
            'status' => 'to_do',
            'due_date' => now()->addDays(7),
        ]);
        $task->setRelation('project', $project);
        $task->setRelation('user', $user);

        $notificationService->notifyTaskCreated($task);
        $this->info('✅ Task creation notification sent');

        // Test task update notification
        $this->info('2. Testing task update notification...');
        $originalData = $task->toArray();
        $task->status = 'in_progress';
        $task->priority = 'medium';

        $notificationService->notifyTaskUpdated($task, $originalData);
        $this->info('✅ Task update notification sent');

        // Test team member addition notification
        $this->info('3. Testing team member addition notification...');
        $notificationService->notifyTeamMemberAdded($project, $user);
        $this->info('✅ Team member addition notification sent');

        $this->info('All test notifications sent successfully!');
        $this->info('Check your email or Laravel logs to verify delivery.');

        return 0;
    }
}