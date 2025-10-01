<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\User;
use App\Models\ListAssignment;
use App\Models\Submission;
use App\Models\SubmissionTask;
use App\Models\Notification;
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
            'schedule_config.weekdays' => 'nullable|array',
            'schedule_config.weekdays.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule_config.day_of_month' => 'nullable|integer|between:1,31',
            'schedule_config.type' => 'nullable|in:specific_days,interval,date_range',
            'schedule_config.days' => 'nullable|array',
            'schedule_config.days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule_config.interval_days' => 'nullable|integer|min:1|max:365',
            'schedule_config.start_date' => 'nullable|date',
            'schedule_config.end_date' => 'nullable|date|after_or_equal:schedule_config.start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'category' => 'nullable|string|max:100',
            'requires_signature' => 'boolean',
            'is_template' => 'boolean',
            'is_active' => 'boolean',
            'create_daily_sublists' => 'boolean',
        ]);

        // Clean up schedule_config based on schedule_type
        if (isset($validated['schedule_config'])) {
            switch ($validated['schedule_type']) {
                case 'once':
                case 'daily':
                    $validated['schedule_config'] = null;
                    break;
                case 'weekly':
                    $validated['schedule_config'] = [
                        'weekdays' => $validated['schedule_config']['weekdays'] ?? []
                    ];
                    break;
                case 'monthly':
                    $validated['schedule_config'] = [
                        'day_of_month' => $validated['schedule_config']['day_of_month'] ?? 1
                    ];
                    break;
                case 'custom':
                    $config = [];
                    $type = $validated['schedule_config']['type'] ?? 'specific_days';
                    $config['type'] = $type;
                    
                    switch ($type) {
                        case 'specific_days':
                            $config['days'] = $validated['schedule_config']['days'] ?? [];
                            break;
                        case 'interval':
                            $config['interval_days'] = $validated['schedule_config']['interval_days'] ?? 1;
                            $config['start_date'] = $validated['schedule_config']['start_date'] ?? null;
                            break;
                        case 'date_range':
                            $config['start_date'] = $validated['schedule_config']['start_date'] ?? null;
                            $config['end_date'] = $validated['schedule_config']['end_date'] ?? null;
                            break;
                    }
                    $validated['schedule_config'] = $config;
                    break;
            }
        }

        $validated['created_by'] = auth()->id();

        $list = TaskList::create($validated);

        // Create daily sub-lists if requested
        if ($request->has('create_daily_sublists') && $list->isMainList()) {
            $list->createDailySubLists();
        }

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
            'schedule_config.weekdays' => 'nullable|array',
            'schedule_config.weekdays.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule_config.day_of_month' => 'nullable|integer|between:1,31',
            'schedule_config.type' => 'nullable|in:specific_days,interval,date_range',
            'schedule_config.days' => 'nullable|array',
            'schedule_config.days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'schedule_config.interval_days' => 'nullable|integer|min:1|max:365',
            'schedule_config.start_date' => 'nullable|date',
            'schedule_config.end_date' => 'nullable|date|after_or_equal:schedule_config.start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
            'category' => 'nullable|string|max:100',
            'requires_signature' => 'boolean',
            'is_template' => 'boolean',
            'is_active' => 'boolean',
            'create_daily_sublists' => 'boolean',
        ]);

        // Clean up schedule_config based on schedule_type
        if (isset($validated['schedule_config'])) {
            switch ($validated['schedule_type']) {
                case 'once':
                case 'daily':
                    $validated['schedule_config'] = null;
                    break;
                case 'weekly':
                    $validated['schedule_config'] = [
                        'weekdays' => $validated['schedule_config']['weekdays'] ?? []
                    ];
                    break;
                case 'monthly':
                    $validated['schedule_config'] = [
                        'day_of_month' => $validated['schedule_config']['day_of_month'] ?? 1
                    ];
                    break;
                case 'custom':
                    $config = [];
                    $type = $validated['schedule_config']['type'] ?? 'specific_days';
                    $config['type'] = $type;
                    
                    switch ($type) {
                        case 'specific_days':
                            $config['days'] = $validated['schedule_config']['days'] ?? [];
                            break;
                        case 'interval':
                            $config['interval_days'] = $validated['schedule_config']['interval_days'] ?? 1;
                            $config['start_date'] = $validated['schedule_config']['start_date'] ?? null;
                            break;
                        case 'date_range':
                            $config['start_date'] = $validated['schedule_config']['start_date'] ?? null;
                            $config['end_date'] = $validated['schedule_config']['end_date'] ?? null;
                            break;
                    }
                    $validated['schedule_config'] = $config;
                    break;
            }
        }

        $list->update($validated);

        // Create daily sub-lists if requested and this is a main list
        if ($request->has('create_daily_sublists') && $list->isMainList()) {
            $list->createDailySubLists();
        }

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
     * Assign list to users/departments/roles
     */
    public function assign(Request $request, TaskList $list)
    {
        // Debug: Log all request data
        \Log::info('Assignment request data:', $request->all());
        
        $validated = $request->validate([
            'assignment_type' => ['required', Rule::in(['user', 'department', 'role'])],
            'user_ids' => 'required_if:assignment_type,user|array|nullable',
            'user_ids.*' => 'required_if:assignment_type,user|exists:users,id',
            'department' => 'required_if:assignment_type,department|string|nullable',
            'role' => 'required_if:assignment_type,role|string|nullable',
            'assigned_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:assigned_date',
        ]);

        // Debug: Log validated data
        \Log::info('Validated assignment data:', $validated);
        
        try {
            // Remove previous assignments of this type for this list
            if ($validated['assignment_type'] === 'user') {
                // Remove all user assignments for this list
                ListAssignment::where('list_id', $list->id)->whereNotNull('user_id')->delete();
                foreach ($validated['user_ids'] as $userId) {
                    ListAssignment::create([
                        'list_id' => $list->id,
                        'user_id' => $userId,
                        'assigned_date' => $validated['assigned_date'],
                        'due_date' => $validated['due_date'],
                    ]);
                }
            } elseif ($validated['assignment_type'] === 'department') {
                // Remove all department assignments for this list
                ListAssignment::where('list_id', $list->id)->whereNotNull('department')->delete();
                ListAssignment::create([
                    'list_id' => $list->id,
                    'department' => $validated['department'],
                    'assigned_date' => $validated['assigned_date'],
                    'department' => $validated['department'],
                    'assigned_date' => $validated['assigned_date'],
                    'due_date' => $validated['due_date'],
                ]);
            } elseif ($validated['assignment_type'] === 'role') {
                // Remove all role assignments for this list
                ListAssignment::where('list_id', $list->id)->whereNotNull('role')->delete();
                ListAssignment::create([
                    'list_id' => $list->id,
                    'role' => $validated['role'],
                    'assigned_date' => $validated['assigned_date'],
                    'due_date' => $validated['due_date'],
                ]);
            }
            
            \Log::info('Assignment successful for list ' . $list->id);
            return back()->with('success', 'List assigned successfully.');
            
        } catch (\Exception $e) {
            \Log::error('Assignment failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Assignment failed: ' . $e->getMessage()]);
        }
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

    /**
     * Reject specific submission task
     */
    public function rejectTask(Request $request, SubmissionTask $submissionTask)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $submissionTask->reject($validated['rejection_reason'], auth()->id());

        return back()->with('success', 'Task rejected successfully.');
    }

    /**
     * Request redo for specific submission task
     */
    public function requestRedo(Request $request, SubmissionTask $submissionTask)
    {
        $submissionTask->requestRedo(auth()->id());

        return back()->with('success', 'Redo requested successfully.');
    }

    /**
     * Get weekly overview for admin dashboard
     */
    public function weeklyOverview(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfWeek());
        $endDate = $request->get('end_date', now()->endOfWeek());

        $employees = User::where('role', 'employee')->where('is_active', true)->get();
        
        $overview = [];
        foreach ($employees as $employee) {
            $submissions = Submission::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->with(['taskList', 'submissionTasks'])
                ->get();

            $overview[$employee->id] = [
                'employee' => $employee,
                'total_submissions' => $submissions->count(),
                'completed' => $submissions->where('status', 'completed')->count(),
                'in_progress' => $submissions->where('status', 'in_progress')->count(),
                'rejected' => $submissions->filter(function ($submission) {
                    return $submission->hasRejectedTasks();
                })->count(),
                'submissions' => $submissions,
            ];
        }

        return view('admin.weekly-overview', compact('overview', 'startDate', 'endDate'));
    }

    /**
     * Create daily sub-lists for a main list
     */
    public function createDailySubLists(TaskList $list)
    {
        if (!$list->isMainList()) {
            return back()->with('error', 'Only main lists can have daily sub-lists.');
        }

        // Update the main list to daily schedule type
        $list->update(['schedule_type' => 'daily']);

        $list->createDailySubLists();

        return back()->with('success', 'Daily sub-lists created successfully. You can now drag and drop tasks to specific days.');
    }
}
