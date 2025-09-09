<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\TaskList;
use App\Models\ListAssignment;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get assigned lists for today
        $todaysLists = $this->getAssignedLists($user, today());
        
        // Get recent submissions
        $recentSubmissions = Submission::with(['taskList'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

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
        ];

        return view('employee.dashboard', compact('todaysLists', 'recentSubmissions', 'stats'));
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

        // Filter out lists that already have submissions today
        $assignedLists = $allAssignments->filter(function ($assignment) use ($user, $date) {
            $existingSubmission = Submission::where('user_id', $user->id)
                ->where('list_id', $assignment->list_id)
                ->whereDate('created_at', $date)
                ->first();

            return !$existingSubmission;
        });

        return $assignedLists->pluck('taskList');
    }
}
