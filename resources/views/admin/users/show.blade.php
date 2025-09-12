@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                <p class="mt-2 text-gray-600">{{ $user->email }}</p>
                <div class="mt-4 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($user->role === 'admin') bg-purple-100 text-purple-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($user->is_active) bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($user->department)
                        <span class="text-sm text-gray-500">{{ $user->department }}</span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    ← Back to Users
                </a>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Basic Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">User Information</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm font-medium text-gray-500">Full Name:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->name }}</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Email:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->email }}</span>
                </div>
                @if($user->phone)
                    <div>
                        <span class="text-sm font-medium text-gray-500">Phone:</span>
                        <span class="text-sm text-gray-900 ml-2">{{ $user->phone }}</span>
                    </div>
                @endif
                <div>
                    <span class="text-sm font-medium text-gray-500">Role:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ ucfirst($user->role) }}</span>
                </div>
                @if($user->department)
                    <div>
                        <span class="text-sm font-medium text-gray-500">Department:</span>
                        <span class="text-sm text-gray-900 ml-2">{{ $user->department }}</span>
                    </div>
                @endif
                <div>
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-500">Member Since:</span>
                    <span class="text-sm text-gray-900 ml-2">{{ $user->created_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Activity Stats -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Activity Statistics</h3>
            @if($user->role === 'employee')
                @php
                    $totalSubmissions = $user->submissions()->count();
                    $completedSubmissions = $user->submissions()->where('status', 'completed')->count();
                    $inProgressSubmissions = $user->submissions()->where('status', 'in_progress')->count();
                    $rejectedTasks = \App\Models\SubmissionTask::whereHas('submission', function($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })->where('status', 'rejected')->count();
                @endphp
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Total Submissions:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $totalSubmissions }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Completed:</span>
                        <span class="text-sm font-medium text-green-600">{{ $completedSubmissions }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">In Progress:</span>
                        <span class="text-sm font-medium text-yellow-600">{{ $inProgressSubmissions }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Rejected Tasks:</span>
                        <span class="text-sm font-medium text-red-600">{{ $rejectedTasks }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Success Rate:</span>
                        <span class="text-sm font-medium text-gray-900">
                            {{ $totalSubmissions > 0 ? round(($completedSubmissions / $totalSubmissions) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
            @else
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Lists Created:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->createdLists()->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Tasks Reviewed:</span>
                        <span class="text-sm font-medium text-gray-900">{{ $user->reviewedTasks()->count() }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Assigned Tasks (for employees) -->
        @if($user->role === 'employee')
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Task Assignments</h3>
                @php
                    $assignedTasks = $user->taskAssignments()->with('task.taskList')->active()->take(5)->get();
                @endphp
                @if($assignedTasks->count() > 0)
                    <div class="space-y-3">
                        @foreach($assignedTasks as $assignment)
                            <div class="border-l-4 border-indigo-400 pl-3">
                                <p class="text-sm font-medium text-gray-900">{{ $assignment->task->title }}</p>
                                <p class="text-xs text-gray-500">{{ $assignment->task->taskList->title }}</p>
                                <p class="text-xs text-gray-400">Assigned {{ $assignment->assigned_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                        @if($user->taskAssignments()->active()->count() > 5)
                            <p class="text-xs text-gray-500">
                                +{{ $user->taskAssignments()->active()->count() - 5 }} more assignments
                            </p>
                        @endif
                    </div>
                @else
                    <p class="text-sm text-gray-500">No specific task assignments</p>
                @endif
            </div>
        @endif
    </div>

    <!-- Recent Activity -->
    @if($user->role === 'employee')
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Submissions</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($user->submissions()->with('taskList')->latest()->take(10)->get() as $submission)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $submission->taskList->title }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $submission->completed_at ? 'Completed' : 'Started' }} {{ ($submission->completed_at ?? $submission->created_at)->format('M j, Y g:i A') }}
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($submission->status === 'completed') bg-yellow-100 text-yellow-800
                                    @elseif($submission->status === 'reviewed') bg-green-100 text-green-800
                                    @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                                <a href="{{ route('admin.submissions.show', $submission) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <p class="text-sm">No submissions yet</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    <!-- Notifications -->
    @if($user->role === 'employee')
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Notifications</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($user->notifications()->latest()->take(5)->get() as $notification)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            @if($notification->isRead())
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Read
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Unread
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <p class="text-sm">No notifications</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>
@endsection
