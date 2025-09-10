@extends('layouts.employee')

@section('content')
<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="mt-1 text-sm text-gray-600">Here are your tasks for today</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending Tasks</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_tasks'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed Today</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_today'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">In Progress</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['in_progress'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rejected Tasks</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['rejected_tasks'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Redo Requests</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['redo_tasks'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Completed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $stats['total_completed'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rejected Tasks & Notifications -->
    @if($rejectedTasks->count() > 0 || $notifications->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Rejected Tasks -->
        @if($rejectedTasks->count() > 0)
        <div class="bg-red-50 border border-red-200 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-red-200">
                <h3 class="text-lg font-medium text-red-900">Rejected Tasks</h3>
                <p class="text-sm text-red-600">These tasks need your attention</p>
            </div>
            <div class="divide-y divide-red-200">
                @foreach($rejectedTasks as $rejectedTask)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-red-900">{{ $rejectedTask->task->title }}</p>
                                <p class="text-sm text-red-600">{{ $rejectedTask->submission->taskList->title }}</p>
                                @if($rejectedTask->rejection_reason)
                                    <p class="text-sm text-red-700 mt-1 bg-red-100 p-2 rounded">
                                        <strong>Reason:</strong> {{ $rejectedTask->rejection_reason }}
                                    </p>
                                @endif
                                <p class="text-xs text-red-500 mt-1">Rejected {{ $rejectedTask->rejected_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('employee.submissions.edit', $rejectedTask->submission) }}" 
                               class="ml-4 inline-flex items-center px-3 py-2 border border-red-300 text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                                Fix
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Notifications -->
        @if($notifications->count() > 0)
        <div class="bg-blue-50 border border-blue-200 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-blue-900">Notifications</h3>
                        <p class="text-sm text-blue-600">{{ $notifications->count() }} unread</p>
                    </div>
                    <a href="{{ route('employee.notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                </div>
            </div>
            <div class="divide-y divide-blue-200">
                @foreach($notifications as $notification)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-blue-900">{{ $notification->title }}</p>
                                <p class="text-sm text-blue-700">{{ $notification->message }}</p>
                                <p class="text-xs text-blue-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <button onclick="markNotificationAsRead({{ $notification->id }})" 
                                    class="ml-4 text-blue-600 hover:text-blue-800">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12l-2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    <!-- Today's Tasks & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Today's Tasks -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Today's Tasks</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($todaysLists as $list)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $list->title }}</p>
                                <p class="text-sm text-gray-500">{{ $list->description }}</p>
                                <div class="mt-1 flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($list->priority === 'urgent') bg-red-100 text-red-800
                                        @elseif($list->priority === 'high') bg-orange-100 text-orange-800
                                        @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($list->priority) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $list->tasks->count() }} tasks</span>
                                    @if($list->isDailySubList())
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($list->weekday) }}
                                        </span>
                                    @endif
                                    @if($list->requires_signature)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                            Signature Required
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <a href="{{ route('employee.lists.show', $list) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Start
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks for today</h3>
                        <p class="mt-1 text-sm text-gray-500">Great job! You're all caught up.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @forelse($recentSubmissions as $submission)
                    <div class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $submission->taskList->title }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $submission->completed_at ? 'Completed ' . $submission->completed_at->diffForHumans() : 'Started ' . $submission->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($submission->status === 'completed') bg-green-100 text-green-800
                                    @elseif($submission->status === 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <p class="text-sm">No recent activity</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Motivational Message -->
    @if($stats['completed_today'] > 0)
        <div class="bg-gradient-to-r from-green-400 to-blue-500 shadow rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-lg font-medium text-white">Great work today!</h3>
                    <p class="text-sm text-green-100">You've completed {{ $stats['completed_today'] }} task{{ $stats['completed_today'] > 1 ? 's' : '' }} today. Keep up the excellent work!</p>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function markNotificationAsRead(notificationId) {
    fetch(`/employee/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the notification from the UI or mark as read
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

// Auto-refresh dashboard every 5 minutes for real-time updates
setInterval(() => {
    // Only refresh if user is still on the page
    if (!document.hidden) {
        location.reload();
    }
}, 5 * 60 * 1000);
</script>

@endsection