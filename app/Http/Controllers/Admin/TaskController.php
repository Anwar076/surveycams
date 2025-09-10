<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(TaskList $list)
    {
        $users = User::where('role', 'employee')->where('is_active', true)->get();
        return view('admin.tasks.create', compact('list', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, TaskList $list)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'required_proof_type' => 'required|in:none,photo,video,text,file,any',
            'is_required' => 'boolean',
            'requires_signature' => 'boolean',
            'order_index' => 'nullable|integer|min:1',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id',
        ]);

        $validated['list_id'] = $list->id;
        $validated['is_required'] = $request->has('is_required');
        $validated['requires_signature'] = $request->has('requires_signature');
        $validated['order_index'] = $validated['order_index'] ?? ($list->tasks()->max('order_index') + 1);

        $task = Task::create($validated);

        // Assign users to the task if specified
        if (!empty($validated['assigned_users'])) {
            foreach ($validated['assigned_users'] as $userId) {
                TaskAssignment::create([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                    'assigned_at' => now(),
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('admin.lists.show', $list)
            ->with('success', 'Task added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $users = User::where('role', 'employee')->where('is_active', true)->get();
        $assignedUsers = $task->assignedUsers->pluck('id')->toArray();
        return view('admin.tasks.edit', compact('task', 'users', 'assignedUsers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'required_proof_type' => 'required|in:none,photo,video,text,file,any',
            'is_required' => 'boolean',
            'requires_signature' => 'boolean',
            'order_index' => 'nullable|integer|min:1',
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id',
        ]);

        $validated['is_required'] = $request->has('is_required');
        $validated['requires_signature'] = $request->has('requires_signature');

        $task->update($validated);

        // Update task assignments
        if (isset($validated['assigned_users'])) {
            // Remove old assignments
            $task->assignments()->delete();
            
            // Add new assignments
            foreach ($validated['assigned_users'] as $userId) {
                TaskAssignment::create([
                    'task_id' => $task->id,
                    'user_id' => $userId,
                    'assigned_at' => now(),
                    'is_active' => true,
                ]);
            }
        }

        return redirect()->route('admin.lists.show', $task->taskList)
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $list = $task->taskList;
        $task->delete();

        return redirect()->route('admin.lists.show', $list)
            ->with('success', 'Task deleted successfully.');
    }
}
