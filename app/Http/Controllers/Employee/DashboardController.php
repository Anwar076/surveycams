<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\ListAssignment;
use App\Models\Submission;
use App\Models\SubmissionTask;
use App\Models\Notification;
use App\Services\ScheduleService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index()
    {
        $user = auth()->user();
        
        // Get assigned lists for today using the new ScheduleService
        $todaysLists = $this->scheduleService->getScheduledTasksForUser($user, today());
        
        // Load tasks with proper filtering for weekly structure lists
        $todaysLists->each(function ($list) {
            if ($list->hasWeeklyStructure()) {
                // For weekly structure lists, only load tasks for today's weekday or general tasks
                $todayWeekday = strtolower(now()->format('l')); // monday, tuesday, etc.
                
                $list->load(['tasks' => function ($query) use ($todayWeekday) {
                    $query->where('is_active', true)
                          ->where(function ($q) use ($todayWeekday) {
                              $q->where('weekday', $todayWeekday)  // Tasks for today
                                ->orWhereNull('weekday');           // General tasks (no specific day)
                          });
                }]);
            } else {
                // For regular lists, load all active tasks
                $list->load(['tasks' => function ($query) {
                    $query->where('is_active', true);
                }]);
            }
        });
        
        // Get recent submissions
        $recentSubmissions = Submission::with(['taskList'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get rejected tasks
        $rejectedTasks = SubmissionTask::with(['task', 'submission.taskList'])
            ->whereHas('submission', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('status', 'rejected')
            ->latest()
            ->take(10)
            ->get();

        // Get tasks that need to be redone
        $redoTasks = SubmissionTask::with(['task', 'submission.taskList'])
            ->whereHas('submission', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('redo_requested', true)
            ->where('status', 'pending')
            ->latest()
            ->get();

        // Get unread notifications
        $notifications = $user->unreadNotifications()->latest()->take(5)->get();

        // Get statistics
        $stats = [
            'pending_tasks' => $todaysLists->count(),
            'completed_today' => Submission::where('user_id', $user->id)
                ->whereDate('completed_at', today())
                ->count(),
            'total_completed' => Submission::where('user_id', $user->id)
                ->where('status', 'completed')
                ->count(),
            'in_progress' => Submission::where('user_id', $user->id)
                ->where('status', 'in_progress')
                ->count(),
            'rejected_tasks' => $rejectedTasks->count(),
            'redo_tasks' => $redoTasks->count(),
            'unread_notifications' => $notifications->count(),
        ];

        return view('employee.dashboard', compact('todaysLists', 'recentSubmissions', 'rejectedTasks', 'redoTasks', 'notifications', 'stats'));
    }

    

    public function markNotificationAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }
}
