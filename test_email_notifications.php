<?php

/**
 * Simple test script for email notifications
 * Run this script to test the email notification system
 * 
 * Usage: php test_email_notifications.php
 */

require_once 'vendor/autoload.php';

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskNotificationService;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Email Notification Test Script\n";
echo "=============================\n\n";

try {
    // Get the first user and project for testing
    $user = User::first();
    $project = Project::first();
    
    if (!$user) {
        echo "❌ No users found in database. Please create a user first.\n";
        exit(1);
    }
    
    if (!$project) {
        echo "❌ No projects found in database. Please create a project first.\n";
        exit(1);
    }
    
    echo "✅ Found test user: {$user->name} ({$user->email})\n";
    echo "✅ Found test project: {$project->name}\n\n";
    
    $notificationService = new TaskNotificationService();
    
    // Test 1: Task Creation Notification
    echo "1. Testing Task Creation Notification...\n";
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
    echo "✅ Task creation notification queued\n\n";
    
    // Test 2: Task Update Notification
    echo "2. Testing Task Update Notification...\n";
    $originalData = $task->toArray();
    $task->status = 'in_progress';
    $task->priority = 'medium';
    
    $notificationService->notifyTaskUpdated($task, $originalData);
    echo "✅ Task update notification queued\n\n";
    
    // Test 3: Team Member Addition Notification
    echo "3. Testing Team Member Addition Notification...\n";
    $notificationService->notifyTeamMemberAdded($project, $user);
    echo "✅ Team member addition notification queued\n\n";
    
    echo "🎉 All test notifications have been queued successfully!\n\n";
    echo "Next steps:\n";
    echo "1. Make sure your email configuration is set up in .env\n";
    echo "2. Run 'php artisan queue:work' to process the queued notifications\n";
    echo "3. Check your email inbox or Laravel logs for the notifications\n\n";
    
    echo "Email Configuration Check:\n";
    echo "MAIL_MAILER: " . env('MAIL_MAILER', 'not set') . "\n";
    echo "MAIL_HOST: " . env('MAIL_HOST', 'not set') . "\n";
    echo "MAIL_FROM_ADDRESS: " . env('MAIL_FROM_ADDRESS', 'not set') . "\n";
    
    if (env('MAIL_MAILER') === 'log') {
        echo "\n📝 Note: Using log driver - check storage/logs/laravel.log for email content\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}