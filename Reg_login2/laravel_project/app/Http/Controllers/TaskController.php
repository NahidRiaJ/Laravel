<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    // Display Today's Task List
    public function index()
    {
        // Fetch only today's tasks and pass them to the view
        $tasks = Task::whereDate('created_at', Carbon::today())->get();
        return view('dashboard', compact('tasks')); // Ensure 'dashboard' view is set up and correctly named
    }

    // Store a New Task
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'how' => 'required|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'course_info' => 'required|string',
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task added successfully');
    }

    // Update an Existing Task
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'how' => 'required|string',
            'status' => 'required|in:Pending,In Progress,Completed',
            'course_info' => 'required|string',
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    // Delete a Task
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
