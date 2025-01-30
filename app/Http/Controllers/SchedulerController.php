<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use Exception;

class SchedulerController extends Controller
{
    /**
     * Executes a scheduled task, updates its status, and sends an email notification.
     *
     * If the task executes successfully, its status is set to 'completed' and a success email is sent.
     * In case of an error, the status is set to 'error', exception details are logged, and an error email is sent.
     *
     * @param  int  $id  The task ID.
     * @return \Illuminate\Http\JsonResponse  The response with the task status and updated information.
     */
    public function executeTask($id)
    {
        $task = Task::find($id);
    
        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }
    
        try {
            if ($task->status === 'in queue') {
                throw new Exception("Simulated exception for testing");
            }
    
            $task->update([
                'status' => 'completed',
                'exception' => null,
            ]);
    
            $statusMessage = 'Task executed successfully';
    
            Mail::send(
                'emails.task_executed', 
                [
                    'task' => $task,
                    'statusMessage' => $statusMessage,
                    'exception' => null
                ],
                function ($message) use ($task) {
                    $message->to('mr.sajidbwn@gmail.com')  // Email recipient
                            ->subject('Task Execution Status: Task #' . $task->id);
                }
            );
    
        } catch (Exception $e) {
            $task->update([
                'status' => 'error',
                'exception' => $e->getMessage(),
            ]);
    
            Log::error('Task execution failed', ['exception' => $e]);
        }
    
        return response()->json(['message' => $statusMessage, 'task' => $task]);
    }
    
    /**
     * Updates the status of a task.
     *
     * Allows changing the task status to 'completed', 'in queue', 'canceled', or 'paused'.
     *
     * @param  int  $id  The task ID.
     * @param  string  $status  The new status for the task.
     * @return \Illuminate\Http\JsonResponse  The response with the updated task status.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:completed,in queue,canceled,paused',
        ]);

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Status updated successfully', 'task' => $task]);
    }

    /**
     * Adds a new task to the scheduler with the specified details.
     *
     * Validates and creates a new task with URL, parameters, and execution date.
     * Returns the newly created task along with a success message.
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request containing task details.
     * @return \Illuminate\Http\JsonResponse  The response with a success message and the created task data.
     */
    public function addTask(Request $request)
    {
        $validated = $request->validate([
            'url' => 'required|url',
            'parameters' => 'nullable|array',
            'execution_date' => 'required|date|after:now',
        ]);

        $task = Task::create([
            'url' => $validated['url'],
            'parameters' => json_encode($validated['parameters']),
            'execution_date' => $validated['execution_date'],
        ]);

        return response()->json(['message' => 'Task added successfully', 'task' => $task]);
    }
}
