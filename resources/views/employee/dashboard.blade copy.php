@extends('layouts.employee')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Clean Header Section -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <!-- Welcome Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">
                                Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, {{ explode(' ', auth()->user()->name)[0] }}
                            </h1>
                            <p class="text-gray-600 font-medium">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- Compact Stats -->
                    <div class="flex flex-wrap gap-4 mt-4">
                        <div class="flex items-center bg-gray-50 rounded-lg px-3 py-2">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-gray-900">{{ $stats['completed_today'] }}</div>
                                <div class="text-xs text-gray-500">Completed</div>
                            </div>
                        </div>
                        <div class="flex items-center bg-gray-50 rounded-lg px-3 py-2">
                            <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-gray-900">{{ $stats['pending_tasks'] }}</div>
                                <div class="text-xs text-gray-500">Pending</div>
                            </div>
                        </div>
                        <div class="flex items-center bg-gray-50 rounded-lg px-3 py-2">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-semibold text-gray-900">{{ $stats['in_progress'] }}</div>
                                <div class="text-xs text-gray-500">In Progress</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Indicator -->
                <div class="flex flex-col items-center lg:items-end">
                    <div class="w-20 h-20 relative">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <circle cx="50" cy="50" r="40" stroke="#e5e7eb" stroke-width="6" fill="none"/>
                            <circle cx="50" cy="50" r="40" 
                                stroke="#3b82f6" 
                                stroke-width="6" 
                                fill="none"
                                stroke-linecap="round"
                                stroke-dasharray="{{ 2 * 3.14159 * 40 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 40 * (1 - (($stats['completed_today'] + $stats['in_progress']) / max(($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']), 1))) }}"
                                class="transition-all duration-1000 ease-out">
                            </circle>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <div class="text-lg font-bold text-gray-900">
                                {{ round((($stats['completed_today'] + $stats['in_progress']) / max(($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']), 1)) * 100) }}%
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Today's Progress</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alerts Section -->
        @if($rejectedTasks->count() > 0 || $notifications->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            @if($rejectedTasks->count() > 0)
            <div class="bg-white rounded-xl border border-red-200 overflow-hidden">
                <div class="bg-red-50 border-b border-red-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Tasks Need Attention</h3>
                                <p class="text-sm text-gray-600">{{ $rejectedTasks->count() }} rejected tasks</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-4">
                    @foreach($rejectedTasks->take(3) as $rejectedTask)
                    <div class="flex items-start justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $rejectedTask->task->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $rejectedTask->submission->taskList->title }}</p>
                        </div>
                        <a href="{{ route('employee.submissions.edit', $rejectedTask->submission) }}" 
                           class="ml-4 bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                            Fix
                        </a>
                    </div>
                    @endforeach
                    @if($rejectedTasks->count() > 3)
                    <div class="text-center mt-3">
                        <a href="#" class="text-sm text-red-600 hover:text-red-700 font-medium">View all {{ $rejectedTasks->count() }} tasks</a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            @if($notifications->count() > 0)
            <div class="bg-white rounded-xl border border-blue-200 overflow-hidden">
                <div class="bg-blue-50 border-b border-blue-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Notifications</h3>
                                <p class="text-sm text-gray-600">{{ $notifications->count() }} unread</p>
                            </div>
                        </div>
                        <a href="{{ route('employee.notifications.index') }}" 
                           class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all</a>
                    </div>
                </div>
                <div class="p-4">
                    @foreach($notifications->take(3) as $notification)
                    <div class="flex items-start justify-between py-3 border-b border-gray-100 last:border-b-0">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $notification->title }}</h4>
                            <p class="text-sm text-gray-600">{{ Str::limit($notification->message, 60) }}</p>
                        </div>
                        <button onclick="markNotificationAsRead({{ $notification->id }})" 
                                class="ml-4 bg-blue-600 text-white p-1 rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Today's Tasks -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-200 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Today's Tasks</h3>
                                    <p class="text-sm text-gray-600">{{ $todaysLists->count() }} lists assigned</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        @forelse($todaysLists as $list)
                        <div class="border border-gray-200 rounded-lg p-4 mb-4 last:mb-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $list->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-3">{{ Str::limit($list->description, 100) }}</p>
                                    
                                    <div class="flex flex-wrap gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium
                                            @if($list->priority === 'urgent') bg-red-100 text-red-800
                                            @elseif($list->priority === 'high') bg-orange-100 text-orange-800
                                            @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($list->priority) }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $list->tasks->count() }} tasks
                                        </span>
                                        @if($list->requires_signature)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-purple-100 text-purple-800">
                                            Signature Required
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('employee.lists.show', $list) }}" 
                                   class="ml-4 bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Start Task
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto bg-green-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">All done for today!</h3>
                            <p class="text-gray-600">You've completed all your assigned tasks. Great work!</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div>
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-200 p-4">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                                <p class="text-sm text-gray-600">Your latest submissions</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        @forelse($recentSubmissions as $submission)
                        <div class="border-b border-gray-100 py-3 last:border-b-0 last:pb-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm">{{ $submission->taskList->title }}</h4>
                                    <p class="text-xs text-gray-600 mt-1">
                                        {{ $submission->completed_at ? 'Completed ' . $submission->completed_at->diffForHumans() : 'Started ' . $submission->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-md font-medium
                                    @if($submission->status === 'completed') bg-green-100 text-green-800
                                    @elseif($submission->status === 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <div class="w-12 h-12 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-sm font-medium">No recent activity</p>
                            <p class="text-xs">Start working on tasks to see progress here</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Subtle Success Message -->
        @if($stats['completed_today'] > 0)
        <div class="bg-green-50 border border-green-200 rounded-xl p-6 mb-8">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-green-900">Great progress today!</h3>
                    <p class="text-green-700">
                        You've completed {{ $stats['completed_today'] }} 
                        {{ $stats['completed_today'] === 1 ? 'task' : 'tasks' }} so far. 
                        Keep up the excellent work!
                    </p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Clean JavaScript -->
<script>
function markNotificationAsRead(notificationId) {
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
    button.disabled = true;
    
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
            button.innerHTML = '<svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            button.innerHTML = originalContent;
            button.disabled = false;
        }
    })
    .catch(error => {
        button.innerHTML = originalContent;
        button.disabled = false;
        console.error('Error:', error);
    });
}
</script>
@endsection
