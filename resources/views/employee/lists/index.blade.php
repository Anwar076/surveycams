@extends('layouts.employee')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Mobile-First Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white p-6 rounded-b-3xl shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold">My Tasks</h1>
                <p class="text-blue-100 text-sm mt-1">{{ $assignedLists->count() }} lists assigned</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Simple Filter Bar -->
    <div class="px-4 -mt-4 relative z-10">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex gap-3">
                <select onchange="window.location.href='{{ route('employee.lists.index') }}?priority=' + this.value" 
                        class="flex-1 px-4 py-3 bg-gray-50 border-0 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="">All Priorities</option>
                    <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                    <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>🟠 High</option>
                    <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                    <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>🟢 Low</option>
                </select>
                <select onchange="window.location.href='{{ route('employee.lists.index') }}?category=' + this.value" 
                        class="flex-1 px-4 py-3 bg-gray-50 border-0 rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="">All Categories</option>
                    @php
                        $categories = $assignedLists->pluck('category')->filter()->unique();
                    @endphp
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Mobile-First Task Cards -->
    <div class="px-4 mt-6 space-y-4">
        @forelse($assignedLists as $list)
            @php
                // Check if user has already started/completed this list today
                $existingSubmission = \App\Models\Submission::where('user_id', auth()->id())
                    ->where('list_id', $list->id)
                    ->whereDate('created_at', today())
                    ->first();
            @endphp
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
                <!-- Card Header -->
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-2xl text-sm font-semibold
                                    @if($list->priority === 'urgent') bg-red-100 text-red-800
                                    @elseif($list->priority === 'high') bg-orange-100 text-orange-800
                                    @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @else bg-green-100 text-green-800 @endif">
                                    @if($list->priority === 'urgent') 🔴 @elseif($list->priority === 'high') 🟠 @elseif($list->priority === 'medium') 🟡 @else 🟢 @endif
                                    {{ ucfirst($list->priority) }}
                                </span>
                                @if($existingSubmission)
                                    <span class="inline-flex items-center px-3 py-1 rounded-2xl text-sm font-semibold
                                        @if($existingSubmission->status === 'completed') bg-green-100 text-green-800
                                        @elseif($existingSubmission->status === 'in_progress') bg-blue-100 text-blue-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        @if($existingSubmission->status === 'completed') ✅ @elseif($existingSubmission->status === 'in_progress') 🔄 @endif
                                        {{ $existingSubmission->status === 'in_progress' ? 'In Progress' : ucfirst($existingSubmission->status) }}
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $list->title }}</h3>
                            @if($list->description)
                                <p class="text-gray-600 text-sm leading-relaxed">{{ Str::limit($list->description, 120) }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Simple Info Row -->
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center gap-4">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                {{ $list->tasks->count() }} tasks
                            </span>
                            @if($list->requires_signature)
                                <span class="flex items-center text-purple-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    Signature
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Progress Bar (if in progress) -->
                    @if($existingSubmission && $existingSubmission->status === 'in_progress')
                        @php
                            $completedTasks = $existingSubmission->submissionTasks->where('status', 'completed')->count();
                            $totalTasks = $existingSubmission->submissionTasks->count();
                            $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-2">
                                <span class="font-medium">Progress</span>
                                <span class="font-semibold">{{ $completedTasks }}/{{ $totalTasks }} tasks</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-3 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Single Action Button -->
                    <div class="mt-6">
                        @if($existingSubmission)
                            @if($existingSubmission->status === 'in_progress')
                                <a href="{{ route('employee.submissions.edit', $existingSubmission) }}" 
                                   class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-4 rounded-2xl font-bold text-center block hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    🔄 Continue Task
                                </a>
                            @elseif($existingSubmission->status === 'completed')
                                <div class="w-full bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 px-6 py-4 rounded-2xl font-bold text-center border border-green-200">
                                    ✅ Completed Today
                                </div>
                            @elseif($existingSubmission->status === 'reviewed')
                                <div class="w-full bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 px-6 py-4 rounded-2xl font-bold text-center border border-green-200">
                                    ✅ Approved
                                </div>
                            @elseif($existingSubmission->status === 'rejected')
                                <a href="{{ route('employee.submissions.edit', $existingSubmission) }}" 
                                   class="w-full bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-4 rounded-2xl font-bold text-center block hover:from-red-600 hover:to-pink-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    ❌ Fix Required
                                </a>
                            @endif
                        @else
                            <a href="{{ route('employee.lists.show', $list) }}" 
                               class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-4 rounded-2xl font-bold text-center block hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                🚀 Start Task
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="px-4 mt-8">
                <div class="bg-white rounded-3xl shadow-lg p-12 text-center">
                    <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">No tasks assigned</h3>
                    <p class="text-gray-600 mb-6">
                        @if(request('priority') || request('category'))
                            No tasks match your current filters.
                        @else
                            You don't have any tasks assigned yet. Check back later!
                        @endif
                    </p>
                    @if(request('priority') || request('category'))
                        <a href="{{ route('employee.lists.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl font-semibold hover:from-blue-600 hover:to-indigo-700 transition-all duration-300">
                            Clear Filters
                        </a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Bottom Spacing -->
    <div class="h-8"></div>
</div>

<!-- Enhanced JavaScript -->
<script>
// Add smooth animations for cards
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
    if (e.target.closest('a')) {
        e.target.closest('a').style.transform = 'scale(0.98)';
    }
});

document.addEventListener('touchend', function(e) {
    if (e.target.closest('a')) {
        setTimeout(() => {
            e.target.closest('a').style.transform = '';
        }, 150);
    }
});
</script>
@endsection