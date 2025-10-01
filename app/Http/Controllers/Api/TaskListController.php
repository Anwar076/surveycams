<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\ListAssignment;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class TaskListController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Display assigned task lists for the authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get assigned lists using ScheduleService
        $assignedLists = $this->scheduleService->getScheduledTasksForUser($user);
        
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

    private function userHasAccessToList($user, $list)
    {
        // Use the ScheduleService to check if the user has access and the list is scheduled
        $assignedLists = $this->scheduleService->getScheduledTasksForUser($user);
        return $assignedLists->contains('id', $list->id);
    }
}
