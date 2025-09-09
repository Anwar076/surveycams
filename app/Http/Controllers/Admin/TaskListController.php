<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\User;
use App\Models\ListAssignment;
use App\Models\Submission;
use App\Models\SubmissionTask;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lists = TaskList::with(['creator', 'tasks'])
            ->withCount('submissions')
            ->latest()
            ->paginate(15);

        return view('admin.lists.index', compact('lists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentLists = TaskList::where('parent_list_id', null)->get();
        return view('admin.lists.create', compact('parentLists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_list_id' => 'nullable|exists:lists,id',
            'schedule_type' => 'required|in:once,daily,weekly,monthly,custom',
            'schedule_config' => 'nullable|array',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'category' => 'nullable|string|max:100',
            'requires_signature' => 'boolean',
            'is_template' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['created_by'] = auth()->id();

        $list = TaskList::create($validated);

        return redirect()->route('admin.lists.show', $list)
            ->with('success', 'Task list created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TaskList $list)
    {
        $list->load(['tasks', 'assignments.user', 'submissions.user']);
        
        return view('admin.lists.show', compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskList $list)
    {
        $parentLists = TaskList::where('parent_list_id', null)
            ->where('id', '!=', $list->id)
            ->get();
            
        return view('admin.lists.edit', compact('list', 'parentLists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskList $list)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_list_id' => 'nullable|exists:lists,id',
            'schedule_type' => 'required|in:once,daily,weekly,monthly,custom',
            'schedule_config' => 'nullable|array',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'category' => 'nullable|string|max:100',
            'requires_signature' => 'boolean',
            'is_template' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $list->update($validated);

        return redirect()->route('admin.lists.show', $list)
            ->with('success', 'Task list updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskList $list)
    {
        $list->delete();

        return redirect()->route('admin.lists.index')
            ->with('success', 'Task list deleted successfully.');
    }

    /**
     * Assign list to users/departments
     */
    public function assign(Request $request, TaskList $list)
    {
        $validated = $request->validate([
            'assignment_type' => 'required|in:user,department,role',
            'user_ids' => 'required_if:assignment_type,user|array',
            'user_ids.*' => 'exists:users,id',
            'department' => 'required_if:assignment_type,department|string',
            'role' => 'required_if:assignment_type,role|string',
            'assigned_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:assigned_date',
        ]);

        if ($validated['assignment_type'] === 'user') {
            foreach ($validated['user_ids'] as $userId) {
                ListAssignment::create([
                    'list_id' => $list->id,
                    'user_id' => $userId,
                    'assigned_date' => $validated['assigned_date'],
                    'due_date' => $validated['due_date'],
                ]);
            }
        } elseif ($validated['assignment_type'] === 'department') {
            ListAssignment::create([
                'list_id' => $list->id,
                'department' => $validated['department'],
                'assigned_date' => $validated['assigned_date'],
                'due_date' => $validated['due_date'],
            ]);
        } elseif ($validated['assignment_type'] === 'role') {
            ListAssignment::create([
                'list_id' => $list->id,
                'role' => $validated['role'],
                'assigned_date' => $validated['assigned_date'],
                'due_date' => $validated['due_date'],
            ]);
        }

        return back()->with('success', 'List assigned successfully.');
    }

    /**
     * View all submissions
     */
    public function submissions(Request $request)
    {
        $query = Submission::with(['user', 'taskList']);

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $submissions = $query->latest()->paginate(20);

        return view('admin.submissions.index', compact('submissions'));
    }

    /**
     * View specific submission
     */
    public function showSubmission(Submission $submission)
    {
        $submission->load(['user', 'taskList', 'submissionTasks.task', 'submissionTasks.reviewer']);
        
        return view('admin.submissions.show', compact('submission'));
    }

    /**
     * Review submission
     */
    public function reviewSubmission(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'task_reviews' => 'required|array',
            'task_reviews.*.status' => 'required|in:approved,rejected',
            'task_reviews.*.comment' => 'nullable|string',
        ]);

        foreach ($validated['task_reviews'] as $taskId => $review) {
            $submissionTask = $submission->submissionTasks()
                ->where('task_id', $taskId)
                ->first();

            if ($submissionTask) {
                $submissionTask->update([
                    'status' => $review['status'],
                    'manager_comment' => $review['comment'],
                    'reviewed_at' => now(),
                    'reviewed_by' => auth()->id(),
                ]);
            }
        }

        // Update overall submission status
        $allApproved = $submission->submissionTasks()
            ->where('status', '!=', 'approved')
            ->count() === 0;

        $submission->update([
            'status' => $allApproved ? 'reviewed' : 'rejected'
        ]);

        return back()->with('success', 'Submission reviewed successfully.');
    }
}
