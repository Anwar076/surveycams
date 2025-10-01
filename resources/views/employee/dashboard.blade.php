@extends('layouts.employee')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div class="mb-8 lg:mb-0">
                    <h1 class="text-4xl lg:text-5xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}</h1>
                    <p class="text-lg text-blue-100 mb-4">{{ now()->format('l, F j, Y') }}</p>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold mb-1">{{ $stats['completed_today'] }}</div>
                        <div class="text-sm text-blue-200">Tasks Today</div>
                    </div>
                    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-4 text-center">
                        <div class="text-3xl font-bold mb-1">{{ $stats['total_completed'] }}</div>
                        <div class="text-sm text-blue-200">Total Completed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 -mt-8 mb-12">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_tasks'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">Pending</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['completed_today'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">Completed</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">In Progress</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-play-circle text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected_tasks'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">Rejected</p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-times-circle text-red-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['redo_tasks'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">Redo</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-redo text-orange-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_completed'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">Total</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-trophy text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if($rejectedTasks->count() > 0 || $notifications->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            @if($rejectedTasks->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-red-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-red-900 flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                            Rejected Tasks
                        </h3>
                        <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">{{ $rejectedTasks->count() }}</span>
                    </div>
                </div>
                <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                    @foreach($rejectedTasks as $rejectedTask)
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 mb-2">{{ $rejectedTask->task->title }}</h4>
                                <p class="text-sm text-gray-600 mb-3">{{ $rejectedTask->submission->taskList->title }}</p>
                                @if($rejectedTask->rejection_reason)
                                <div class="bg-red-50 rounded-lg p-3 mb-3">
                                    <p class="text-sm text-red-800">{{ $rejectedTask->rejection_reason }}</p>
                                </div>
                                @endif
                                <p class="text-xs text-gray-500">{{ $rejectedTask->rejected_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('employee.submissions.edit', $rejectedTask->submission) }}" 
                               class="ml-4 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                Fix
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($notifications->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-blue-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-blue-900 flex items-center">
                            <i class="fas fa-bell text-blue-500 mr-3"></i>
                            Notifications
                        </h3>
                        <div class="flex items-center space-x-3">
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">{{ $notifications->count() }}</span>
                            <a href="{{ route('employee.notifications.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                    </div>
                </div>
                <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                    @foreach($notifications as $notification)
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900 mb-2">{{ $notification->title }}</h4>
                                <p class="text-sm text-gray-700 mb-3">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <button onclick="markNotificationAsRead({{ $notification->id }})" 
                                    class="ml-4 text-blue-600 hover:text-blue-800 p-2">
                                <i class="fas fa-check"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-12">
            <!-- Today's Tasks -->
            <div class="xl:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-calendar-day text-indigo-500 mr-3"></i>
                                Today's Tasks
                            </h3>
                            <span class="text-sm text-gray-500">{{ $todaysLists->count() }} lists</span>
                        </div>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($todaysLists as $list)
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-lg font-medium text-gray-900 mb-2">{{ $list->title }}</h4>
                                    <p class="text-gray-600 mb-4">{{ $list->description }}</p>
                                    
                                    <div class="flex items-center space-x-2 flex-wrap gap-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($list->priority === 'urgent') bg-red-100 text-red-800
                                            @elseif($list->priority === 'high') bg-orange-100 text-orange-800  
                                            @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($list->priority) }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $list->tasks->count() }} tasks
                                        </span>
                                        @if($list->requires_signature)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Signature Required
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('employee.lists.show', $list) }}" 
                                   class="ml-6 bg-indigo-600 text-white px-6 py-3 rounded-xl font-medium hover:bg-indigo-700 transition-colors">
                                    Start
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-check-circle text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">All done for today!</h3>
                            <p class="text-gray-500">You've completed all your assigned tasks</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <i class="fas fa-history text-gray-400 mr-3"></i>
                            Recent Activity
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($recentSubmissions as $submission)
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900 text-sm mb-1">{{ $submission->taskList->title }}</h4>
                                    <p class="text-xs text-gray-500 mb-2">
                                        {{ $submission->completed_at ? 'Completed ' . $submission->completed_at->diffForHumans() : 'Started ' . $submission->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-full font-medium
                                    @if($submission->status === 'completed') bg-green-100 text-green-800
                                    @elseif($submission->status === 'reviewed') bg-blue-100 text-blue-800
                                    @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-8 text-center text-gray-500">
                            <i class="fas fa-history text-gray-300 text-xl mb-2"></i>
                            <p class="text-sm">No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if($stats['completed_today'] > 0)
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-600 to-blue-600 rounded-3xl p-8 text-white shadow-2xl">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-white bg-opacity-5">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white bg-opacity-10 rounded-full"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white bg-opacity-10 rounded-full"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex items-center">
            <div class="w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-8 shadow-lg">
                <div class="relative">
                <i class="fas fa-trophy text-3xl text-yellow-300 animate-pulse"></i>
                <div class="absolute -top-1 -right-1 w-3 h-3 bg-yellow-400 rounded-full animate-ping"></div>
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center mb-3">
                <h3 class="text-3xl font-bold mr-3">Fantastic Work!</h3>
                <div class="flex">
                    @for($i = 0; $i < min($stats['completed_today'], 5); $i++)
                    <i class="fas fa-star text-yellow-300 text-lg animate-bounce" style="animation-delay: {{ $i * 0.1 }}s;"></i>
                    @endfor
                </div>
                </div>
                <p class="text-xl opacity-95 leading-relaxed">
                You have successfully completed
                <span class="font-bold text-yellow-300 text-2xl">{{ $stats['completed_today'] }}</span> 
                out of <span class="font-bold text-yellow-300 text-2xl">{{ $stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress'] }}</span> tasks today!
                @if($stats['completed_today'] >= 5)
                    You're on fire!
                @elseif($stats['completed_today'] >= 3)
                    Amazing productivity!
                @else
                    Great start!
                @endif
                </p>
                <div class="mt-4 flex items-center text-emerald-100">
                <i class="fas fa-chart-line mr-2"></i>
                <span class="text-sm">Keep up the momentum!</span>
                </div>
            </div>
            </div>
            
            <!-- Progress Indicator -->
            <div class="mt-6 relative">
            <div class="w-full bg-white bg-opacity-20 rounded-full h-2">
                <div class="bg-yellow-400 h-2 rounded-full transition-all duration-1000 ease-out shadow-sm" 
                 style="width: {{ ($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']) > 0 ? (($stats['completed_today'] / ($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress'])) * 100) : 0 }}%"></div>
            </div>
            <p class="text-xs text-emerald-100 mt-2 text-center">
                {{ round(($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']) > 0 ? (($stats['completed_today'] / ($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress'])) * 100) : 0) }}% of today's tasks completed
            </p>
            </div>
        </div>
        @endif
    </div>
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
            location.reload();
        }
    });
}

setInterval(() => {
    if (!document.hidden) {
        location.reload();
    }
}, 5 * 60 * 1000);
</script>
@endsection
