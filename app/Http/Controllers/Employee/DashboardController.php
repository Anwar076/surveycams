<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\ListAssignment;
use App\Models\Submission;
use App\Models\SubmissionTask;
use App\Models\Notification;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get assigned lists for today (including daily sub-lists)
        $todaysLists = $this->getAssignedLists($user, today());
        
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

    private function getAssignedLists($user, $date)
    {
        // Get lists assigned directly to user
        $directAssignments = ListAssignment::with(['taskList'])
            ->where('user_id', $user->id)
            ->where('assigned_date', '<=', $date)
            ->where('is_active', true)
            ->whereHas('taskList', function ($query) {
                $query->where('is_active', true);
            });

        // Get lists assigned by department
        $departmentAssignments = ListAssignment::with(['taskList'])
            ->where('department', $user->department)
            ->where('assigned_date', '<=', $date)
            ->where('is_active', true)
            ->whereHas('taskList', function ($query) {
                $query->where('is_active', true);
            });

        // Get lists assigned by role
        $roleAssignments = ListAssignment::with(['taskList'])
            ->where('role', $user->role)
            ->where('assigned_date', '<=', $date)
            ->where('is_active', true)
            ->whereHas('taskList', function ($query) {
                $query->where('is_active', true);
            });

        // Combine all assignments and remove duplicates
        $allAssignments = $directAssignments->get()
            ->merge($departmentAssignments->get())
            ->merge($roleAssignments->get())
            ->unique('list_id');

        // Get today's weekday for daily sub-lists
        $today = strtolower(now()->format('l')); // 'monday', 'tuesday', etc.
        $todaysLists = collect();

        foreach ($allAssignments as $assignment) {
            $taskList = $assignment->taskList;
            
            // If this is a main list, check for daily sub-list
            if ($taskList->isMainList()) {
                $dailySubList = $taskList->getTodaySubList();
                if ($dailySubList) {
                    $taskList = $dailySubList;
                }
            }
            
            // Check if there's already a submission for this list today
            $existingSubmission = Submission::where('user_id', $user->id)
                ->where('list_id', $taskList->id)
                ->whereDate('created_at', $date)
                ->first();

            if (!$existingSubmission) {
                $todaysLists->push($taskList);
            }
        }

        return $todaysLists->unique('id');
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }
}
