<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\ListAssignment;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    /**
     * Display assigned task lists for the authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get assigned lists
        $assignedLists = $this->getAssignedLists($user);
        
        return response()->json([
            'data' => $assignedLists->map(function ($list) {
                return [
                    'id' => $list->id,
                    'title' => $list->title,
                    'description' => $list->description,
                    'priority' => $list->priority,
                    'category' => $list->category,
                    'schedule_type' => $list->schedule_type,
                    'requires_signature' => $list->requires_signature,
                    'tasks_count' => $list->tasks->count(),
                    'created_at' => $list->created_at,
                ];
            })
        ]);
    }

    /**
     * Display the specified task list with tasks
     */
    public function show(Request $request, TaskList $list)
    {
        $user = $request->user();
        
        // Check if user has access to this list
        if (!$this->userHasAccessToList($user, $list)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $list->load('tasks');

        return response()->json([
            'data' => [
                'id' => $list->id,
                'title' => $list->title,
                'description' => $list->description,
                'priority' => $list->priority,
                'category' => $list->category,
                'schedule_type' => $list->schedule_type,
                'requires_signature' => $list->requires_signature,
                'tasks' => $list->tasks->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'description' => $task->description,
                        'instructions' => $task->instructions,
                        'required_proof_type' => $task->required_proof_type,
                        'is_required' => $task->is_required,
                        'order_index' => $task->order_index,
                    ];
                }),
                'created_at' => $list->created_at,
            ]
        ]);
    }

    private function getAssignedLists($user)
    {
        // Get lists assigned directly to user
        $directAssignments = ListAssignment::with(['taskList.tasks'])
            ->where('user_id', $user->id)
            ->where('assigned_date', '<=', today())
            ->where('is_active', true)
            ->whereHas('taskList', function ($query) {
                $query->where('is_active', true);
            });

        // Get lists assigned by department
        $departmentAssignments = ListAssignment::with(['taskList.tasks'])
            ->where('department', $user->department)
            ->where('assigned_date', '<=', today())
            ->where('is_active', true)
            ->whereHas('taskList', function ($query) {
                $query->where('is_active', true);
            });

        // Combine all assignments and remove duplicates
        return $directAssignments->get()
            ->merge($departmentAssignments->get())
            ->unique('list_id')
            ->pluck('taskList');
    }

    private function userHasAccessToList($user, $list)
    {
        return ListAssignment::where('list_id', $list->id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('department', $user->department)
                    ->orWhere('role', $user->role);
            })
            ->where('is_active', true)
            ->exists();
    }
}
