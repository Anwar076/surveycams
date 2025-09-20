@extends('layouts.employee')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Mobile-First Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white p-6 rounded-b-3xl shadow-lg">
        <div class="flex items-center justify-between mb-4">
            <button onclick="history.back()" class="w-10 h-10 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-2xl flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
            </div>
        </div>
        <h1 class="text-2xl font-bold mb-2">{{ $list->title }}</h1>
        <p class="text-indigo-100 text-sm">{{ $list->description }}</p>
    </div>

    <!-- Priority & Status Badges -->
    <div class="px-4 -mt-4 relative z-10">
        <div class="bg-white rounded-2xl shadow-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold
                        @if($list->priority === 'urgent') bg-red-100 text-red-800
                        @elseif($list->priority === 'high') bg-orange-100 text-orange-800
                        @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        @if($list->priority === 'urgent') 🔴 @elseif($list->priority === 'high') 🟠 @elseif($list->priority === 'medium') 🟡 @else 🟢 @endif
                        {{ ucfirst($list->priority) }} Priority
                    </span>
                    <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gray-100 text-gray-800">
                        📋 {{ $list->tasks->count() }} tasks
                    </span>
                    @if($list->requires_signature)
                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-purple-100 text-purple-800">
                            ✍️ Signature Required
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Simplified Task Preview -->
    <div class="px-4 mt-6">
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Task Overview
                </h3>
                <div class="space-y-3">
                    @foreach($list->tasks as $index => $task)
                        <div class="flex items-start p-4 bg-gray-50 rounded-2xl">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-bold text-gray-600">{{ $index + 1 }}</span>
                                </div>
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="font-semibold text-gray-900 text-sm">{{ $task->title }}</h4>
                                @if($task->description)
                                    <p class="text-xs text-gray-600 mt-1">{{ Str::limit($task->description, 80) }}</p>
                                @endif
                                <div class="flex items-center gap-2 mt-2">
                                    @if($task->is_required)
                                        <span class="inline-flex items-center px-2 py-1 rounded-xl text-xs font-medium bg-red-100 text-red-800">
                                            Required
                                        </span>
                                    @endif
                                    @if($task->requires_signature)
                                        <span class="inline-flex items-center px-2 py-1 rounded-xl text-xs font-medium bg-purple-100 text-purple-800">
                                            ✍️ Signature
                                        </span>
                                    @endif
                                    @if($task->required_proof_type !== 'none')
                                        <span class="inline-flex items-center px-2 py-1 rounded-xl text-xs font-medium bg-blue-100 text-blue-800">
                                            📎 {{ ucfirst($task->required_proof_type) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Simple Instructions -->
    <div class="px-4 mt-6">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-3xl p-6">
            <div class="flex items-start">
                <div class="w-10 h-10 bg-blue-100 rounded-2xl flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-blue-900 mb-3">How it works</h3>
                    <div class="space-y-2 text-sm text-blue-800">
                        <div class="flex items-center">
                            <span class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 text-xs font-bold">1</span>
                            Complete tasks in order
                        </div>
                        <div class="flex items-center">
                            <span class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 text-xs font-bold">2</span>
                            Upload proof when required
                        </div>
                        <div class="flex items-center">
                            <span class="w-6 h-6 bg-blue-200 rounded-full flex items-center justify-center mr-3 text-xs font-bold">3</span>
                            @if($list->requires_signature) Sign and submit @else Submit for review @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="px-4 mt-8 mb-8">
        @if($existingSubmission)
            <a href="{{ route('employee.submissions.edit', $existingSubmission) }}" 
               class="w-full bg-gradient-to-r from-green-500 to-emerald-600 text-white px-8 py-5 rounded-3xl font-bold text-center block hover:from-green-600 hover:to-emerald-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-lg">
                🔄 Continue Working
            </a>
        @else
            <form method="POST" action="{{ route('employee.submissions.start', $list) }}">
                @csrf
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-5 rounded-3xl font-bold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-lg">
                    🚀 Start Task
                </button>
            </form>
        @endif
    </div>
</div>

<!-- Enhanced JavaScript -->
<script>
// Add smooth animations
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.bg-white.rounded-3xl, .bg-gradient-to-r');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 150);
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