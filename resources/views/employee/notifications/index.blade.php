@extends('layouts.employee')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                <p class="mt-1 text-sm text-gray-600">Stay updated on your task status</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="markAllAsRead()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Mark All Read
                </button>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="bg-white shadow rounded-lg">
        @forelse($notifications as $notification)
            <div class="px-6 py-4 border-b border-gray-200 {{ $notification->isRead() ? 'bg-gray-50' : 'bg-white' }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            @if($notification->type === 'task_rejected')
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @elseif($notification->type === 'task_redo_requested')
                                <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $notification->title }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                            @if(!$notification->isRead())
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-2">
                                    New
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($notification->data && isset($notification->data['submission_id']))
                            <a href="{{ route('employee.submissions.edit', $notification->data['submission_id']) }}" 
                               class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                View Task
                            </a>
                        @endif
                        @if(!$notification->isRead())
                            <button onclick="markAsRead({{ $notification->id }})" 
                                    class="text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12l-2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"></path>
                                </svg>
                            </button>
                        @endif
                        <button onclick="deleteNotification({{ $notification->id }})" 
                                class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-12 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 17H6l5 5v-5z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                <p class="mt-1 text-sm text-gray-500">You're all caught up! No new notifications to display.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $notifications->links() }}
        </div>
    @endif
</div>

<script>
function markAsRead(notificationId) {
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
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function markAllAsRead() {
    fetch('/employee/notifications/mark-all-read', {
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
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        fetch(`/employee/notifications/${notificationId}`, {
            method: 'DELETE',
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
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>
@endsection