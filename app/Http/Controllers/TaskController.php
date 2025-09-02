<?php
namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Services\TaskNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    protected $notificationService;

    public function __construct(TaskNotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Project $project)
    {
        $tasks = $project->tasks()->get()->groupBy('status');
        $users = $project->users()->get();  
        return view('tasks.index', compact('project', 'tasks', 'users'));
    }

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = $project->tasks()->create($request->all());

        // Send notifications to team members
        $this->notificationService->notifyTaskCreated($task);

        return redirect()->route('projects.tasks.index', $project)->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:to_do,in_progress,completed',
        ]);

        // Store original data for comparison
        $originalData = $task->toArray();

        $task->update($request->all());

        // Send notifications to team members
        $this->notificationService->notifyTaskUpdated($task, $originalData);

        return redirect()->route('projects.tasks.index', $task->project_id)->with('success', 'Task updated successfully.');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Store original data for comparison
        $originalData = $task->toArray();
        
        $task->status = $request->input('status');
        $task->save();

        // Send notifications to team members
        $this->notificationService->notifyTaskUpdated($task, $originalData);

        return response()->json(['message' => 'Task status updated successfully.']);
    }
}
