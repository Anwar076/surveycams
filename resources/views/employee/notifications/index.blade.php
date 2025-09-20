@extends('layouts.employee')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Mobile-First Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-6 rounded-b-3xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">Notifications</h1>
                <p class="text-blue-100 text-sm mt-1">{{ $notifications->count() }} notifications</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 17H6l5 5v-5z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Simple Action Bar -->
    @if($notifications->count() > 0)
    <div class="px-4 -mt-4 relative z-10">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <button onclick="markAllAsRead()" 
                    class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-2xl font-semibold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                ✅ Mark All as Read
            </button>
        </div>
    </div>
    @endif

    <!-- Mobile-First Notifications -->
    <div class="px-4 mt-6 space-y-4">
        @forelse($notifications as $notification)
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden {{ $notification->isRead() ? 'opacity-75' : '' }}">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mr-4">
                            @if($notification->type === 'task_rejected')
                                <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            @elseif($notification->type === 'task_redo_requested')
                                <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 17H6l5 5v-5z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $notification->title }}</h3>
                                @if(!$notification->isRead())
                                    <span class="inline-flex items-center px-3 py-1 rounded-2xl text-xs font-semibold bg-blue-100 text-blue-800">
                                        New
                                    </span>
                                @endif
                            </div>
                            <p class="text-gray-600 text-sm leading-relaxed mb-3">{{ $notification->message }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                <div class="flex items-center gap-2">
                                    @if($notification->data && isset($notification->data['submission_id']))
                                        <a href="{{ route('employee.submissions.edit', $notification->data['submission_id']) }}" 
                                           class="text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                            View Task →
                                        </a>
                                    @endif
                                    @if(!$notification->isRead())
                                        <button onclick="markAsRead({{ $notification->id }})" 
                                                class="w-8 h-8 bg-green-100 rounded-xl flex items-center justify-center hover:bg-green-200 transition-colors">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <button onclick="deleteNotification({{ $notification->id }})" 
                                            class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center hover:bg-red-200 transition-colors">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-4 mt-8">
                <div class="bg-white rounded-3xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM11 17H6l5 5v-5z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">All caught up!</h3>
                    <p class="text-gray-600 mb-6">No notifications to display. You're all set!</p>
                    <a href="{{ route('employee.dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl font-semibold hover:from-blue-600 hover:to-indigo-700 transition-all duration-300">
                        ← Back to Dashboard
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="px-4 mt-6">
            <div class="bg-white rounded-2xl shadow-lg p-4">
                {{ $notifications->links() }}
            </div>
        </div>
    @endif

    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>

<!-- Enhanced JavaScript -->
<script>
function markAsRead(notificationId) {
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-4 h-4 text-green-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
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

function markAllAsRead() {
    const button = event.target;
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-5 h-5 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Marking All as Read...';
    button.disabled = true;
    
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
            button.innerHTML = '✅ All Marked as Read!';
            setTimeout(() => {
                location.reload();
            }, 1500);
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

function deleteNotification(notificationId) {
    if (confirm('Are you sure you want to delete this notification?')) {
        const button = event.target.closest('button');
        const originalContent = button.innerHTML;
        button.innerHTML = '<svg class="w-4 h-4 text-red-600 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
        button.disabled = true;
        
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
                button.closest('.bg-white.rounded-3xl').style.opacity = '0';
                button.closest('.bg-white.rounded-3xl').style.transform = 'translateX(-100%)';
                setTimeout(() => {
                    location.reload();
                }, 300);
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
}

// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white.rounded-3xl');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

// Add touch feedback for mobile
document.addEventListener('touchstart', function(e) {
    if (e.target.closest('button, a')) {
        e.target.closest('button, a').style.transform = 'scale(0.98)';
    }
});

document.addEventListener('touchend', function(e) {
    if (e.target.closest('button, a')) {
        setTimeout(() => {
            e.target.closest('button, a').style.transform = '';
        }, 150);
    }
});
</script>
@endsection