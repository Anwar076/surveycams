<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TaskList;
use App\Models\Submission;
use App\Models\SubmissionTask;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_employees' => User::where('role', 'employee')->count(),
            'total_lists' => TaskList::active()->count(),
            'pending_submissions' => Submission::where('status', 'completed')->count(),
            'completed_today' => Submission::whereDate('completed_at', today())->count(),
        ];

        // Recent submissions for review
        $recentSubmissions = Submission::with(['user', 'taskList'])
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        // Most rejected tasks (for improvement insights)
        $rejectedTasks = SubmissionTask::with(['task'])
            ->where('status', 'rejected')
            ->selectRaw('task_id, count(*) as rejection_count')
            ->groupBy('task_id')
            ->orderByDesc('rejection_count')
            ->take(5)
            ->get();

        // Completion rates by employee (last 30 days)
        $employeeStats = User::where('role', 'employee')
            ->withCount([
                'submissions as total_submissions' => function ($query) {
                    $query->where('created_at', '>=', now()->subDays(30));
                },
                'submissions as completed_submissions' => function ($query) {
                    $query->where('status', 'completed')
                          ->where('created_at', '>=', now()->subDays(30));
                }
            ])
            ->take(10)
            ->get()
            ->map(function ($user) {
                $user->completion_rate = $user->total_submissions > 0 
                    ? round(($user->completed_submissions / $user->total_submissions) * 100, 1)
                    : 0;
                return $user;
            });

        return view('admin.dashboard', compact('stats', 'recentSubmissions', 'rejectedTasks', 'employeeStats'));
    }
}
