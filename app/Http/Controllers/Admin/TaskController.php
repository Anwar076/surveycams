<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(TaskList $list)
    {
        return view('admin.tasks.create', compact('list'));
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
            'order_index' => 'nullable|integer|min:1',
        ]);

        $validated['list_id'] = $list->id;
        $validated['is_required'] = $request->has('is_required');
        $validated['order_index'] = $validated['order_index'] ?? ($list->tasks()->max('order_index') + 1);

        $task = Task::create($validated);

        return redirect()->route('admin.lists.show', $list)
            ->with('success', 'Task added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.edit', compact('task'));
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
            'order_index' => 'nullable|integer|min:1',
        ]);

        $validated['is_required'] = $request->has('is_required');

        $task->update($validated);

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
