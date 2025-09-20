@extends('layouts.employee')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Enhanced Hero Section -->
    <div class="relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-16">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
                <!-- Welcome Content -->
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-2">
                                Good {{ now()->hour < 12 ? 'Morning' : (now()->hour < 17 ? 'Afternoon' : 'Evening') }}, 
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-orange-300">
                                    {{ explode(' ', auth()->user()->name)[0] }}
                                </span>
                            </h1>
                            <p class="text-lg sm:text-xl text-blue-100 font-medium">{{ now()->format('l, F j, Y') }}</p>
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-8">
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300">
                            <div class="text-2xl sm:text-3xl font-bold text-white mb-1">{{ $stats['completed_today'] }}</div>
                            <div class="text-sm text-blue-200 font-medium">Completed Today</div>
                        </div>
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300">
                            <div class="text-2xl sm:text-3xl font-bold text-white mb-1">{{ $stats['pending_tasks'] }}</div>
                            <div class="text-sm text-blue-200 font-medium">Pending</div>
                        </div>
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300">
                            <div class="text-2xl sm:text-3xl font-bold text-white mb-1">{{ $stats['in_progress'] }}</div>
                            <div class="text-sm text-blue-200 font-medium">In Progress</div>
                        </div>
                        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-4 text-center border border-white border-opacity-20 hover:bg-opacity-20 transition-all duration-300">
                            <div class="text-2xl sm:text-3xl font-bold text-white mb-1">{{ $stats['total_completed'] }}</div>
                            <div class="text-sm text-blue-200 font-medium">Total Completed</div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Circle -->
                <div class="flex justify-center lg:justify-end">
                    <div class="relative w-48 h-48 sm:w-56 sm:h-56">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Background Circle -->
                            <circle cx="50" cy="50" r="45" stroke="rgba(255,255,255,0.2)" stroke-width="8" fill="none"/>
                            <!-- Progress Circle -->
                            <circle cx="50" cy="50" r="45" 
                                stroke="url(#gradient)" 
                                stroke-width="8" 
                                fill="none"
                                stroke-linecap="round"
                                stroke-dasharray="{{ 2 * 3.14159 * 45 }}"
                                stroke-dashoffset="{{ 2 * 3.14159 * 45 * (1 - (($stats['completed_today'] + $stats['in_progress']) / max(($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']), 1))) }}"
                                class="transition-all duration-1000 ease-out">
                            </circle>
                            <defs>
                                <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" style="stop-color:#fbbf24;stop-opacity:1" />
                                    <stop offset="100%" style="stop-color:#f59e0b;stop-opacity:1" />
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center text-white">
                            <div class="text-3xl sm:text-4xl font-bold">
                                {{ round((($stats['completed_today'] + $stats['in_progress']) / max(($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']), 1)) * 100) }}%
                            </div>
                            <div class="text-sm text-blue-200 font-medium">Progress</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10">
        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-16">
            <!-- Pending Tasks Card -->
            <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 group-hover:text-yellow-600 transition-colors">{{ $stats['pending_tasks'] }}</p>
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span>Awaiting action</span>
                </div>
            </div>

            <!-- Completed Today Card -->
            <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $stats['completed_today'] }}</p>
                        <p class="text-sm font-medium text-gray-500">Completed</p>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>Today's achievements</span>
                </div>
            </div>

            <!-- In Progress Card -->
            <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $stats['in_progress'] }}</p>
                        <p class="text-sm font-medium text-gray-500">In Progress</p>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    <span>Currently working</span>
                </div>
            </div>

            <!-- Rejected Tasks Card -->
            <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-400 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $stats['rejected_tasks'] }}</p>
                        <p class="text-sm font-medium text-gray-500">Rejected</p>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <span>Needs attention</span>
                </div>
            </div>

            <!-- Redo Tasks Card -->
            <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-400 to-red-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors">{{ $stats['redo_tasks'] }}</p>
                        <p class="text-sm font-medium text-gray-500">Redo</p>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span>Requires revision</span>
                </div>
            </div>

            <!-- Total Completed Card -->
            <div class="group bg-white rounded-3xl shadow-lg border border-gray-100 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 cursor-pointer">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ $stats['total_completed'] }}</p>
                        <p class="text-sm font-medium text-gray-500">Total</p>
                    </div>
                </div>
                <div class="flex items-center text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span>All-time success</span>
                </div>
            </div>
        </div>

        <!-- Enhanced Alerts Section -->
        @if($rejectedTasks->count() > 0 || $notifications->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            @if($rejectedTasks->count() > 0)
            <div class="bg-white rounded-3xl shadow-xl border border-red-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-red-500 to-pink-500 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Rejected Tasks</h3>
                                <p class="text-red-100 text-sm">Tasks that need your attention</p>
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl px-4 py-2">
                            <span class="text-white font-bold text-lg">{{ $rejectedTasks->count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @foreach($rejectedTasks as $rejectedTask)
                    <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2 text-lg">{{ $rejectedTask->task->title }}</h4>
                                <p class="text-gray-600 mb-3">{{ $rejectedTask->submission->taskList->title }}</p>
                                @if($rejectedTask->rejection_reason)
                                <div class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-4">
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm text-red-800 font-medium">{{ $rejectedTask->rejection_reason }}</p>
                                    </div>
                                </div>
                                @endif
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $rejectedTask->rejected_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <a href="{{ route('employee.submissions.edit', $rejectedTask->submission) }}" 
                               class="ml-6 bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-3 rounded-2xl font-semibold hover:from-red-600 hover:to-pink-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Fix Now
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($notifications->count() > 0)
            <div class="bg-white rounded-3xl shadow-xl border border-blue-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6a2 2 0 012 2v9a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Notifications</h3>
                                <p class="text-blue-100 text-sm">Stay updated with latest news</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl px-4 py-2">
                                <span class="text-white font-bold text-lg">{{ $notifications->count() }}</span>
                            </div>
                            <a href="{{ route('employee.notifications.index') }}" 
                               class="bg-white bg-opacity-20 backdrop-blur-sm text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-opacity-30 transition-all duration-300">
                                View All
                            </a>
                        </div>
                    </div>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @foreach($notifications as $notification)
                    <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 mb-2 text-lg">{{ $notification->title }}</h4>
                                <p class="text-gray-700 mb-3">{{ $notification->message }}</p>
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <button onclick="markNotificationAsRead({{ $notification->id }})" 
                                    class="ml-6 bg-gradient-to-r from-blue-500 to-indigo-500 text-white p-3 rounded-2xl hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
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

        <!-- Enhanced Main Content -->
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 mb-16">
            <!-- Today's Tasks -->
            <div class="xl:col-span-2">
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-white">Today's Tasks</h3>
                                    <p class="text-indigo-100 text-sm">{{ $todaysLists->count() }} lists assigned</p>
                                </div>
                            </div>
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl px-4 py-2">
                                <span class="text-white font-bold text-lg">{{ $todaysLists->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($todaysLists as $list)
                        <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="text-xl font-bold text-gray-900 mb-3">{{ $list->title }}</h4>
                                    <p class="text-gray-600 mb-4 leading-relaxed">{{ $list->description }}</p>
                                    
                                    <div class="flex items-center space-x-3 flex-wrap gap-3">
                                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold
                                            @if($list->priority === 'urgent') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                                            @elseif($list->priority === 'high') bg-gradient-to-r from-orange-100 to-yellow-100 text-orange-800 border border-orange-200
                                            @elseif($list->priority === 'medium') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                                            @else bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 @endif">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            {{ ucfirst($list->priority) }} Priority
                                        </span>
                                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gray-100 text-gray-800 border border-gray-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                            </svg>
                                            {{ $list->tasks->count() }} tasks
                                        </span>
                                        @if($list->requires_signature)
                                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800 border border-purple-200">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                            Signature Required
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <a href="{{ route('employee.lists.show', $list) }}" 
                                   class="ml-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-4 rounded-2xl font-bold hover:from-indigo-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Start Task
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="p-16 text-center">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-green-100 to-emerald-100 rounded-full flex items-center justify-center mb-6">
                                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">All done for today!</h3>
                            <p class="text-gray-500 text-lg">You've completed all your assigned tasks. Great work!</p>
                            <div class="mt-6">
                                <div class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 rounded-2xl font-semibold">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.5 2.5L15 8l-2.5-2.5L15 3zm-5 5l2.5 2.5L10 13l-2.5-2.5L10 8z"></path>
                                    </svg>
                                    Perfect Score!
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div>
                <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300">
                    <div class="bg-gradient-to-r from-gray-500 to-slate-600 p-6">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-white">Recent Activity</h3>
                                <p class="text-gray-200 text-sm">Your latest submissions</p>
                            </div>
                        </div>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($recentSubmissions as $submission)
                        <div class="p-6 border-b border-gray-100 last:border-b-0 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="font-bold text-gray-900 text-lg mb-2">{{ $submission->taskList->title }}</h4>
                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ $submission->completed_at ? 'Completed ' . $submission->completed_at->diffForHumans() : 'Started ' . $submission->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="text-sm px-4 py-2 rounded-2xl font-semibold border
                                    @if($submission->status === 'completed') bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-green-200
                                    @elseif($submission->status === 'reviewed') bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-blue-200
                                    @elseif($submission->status === 'rejected') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border-red-200
                                    @else bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border-yellow-200 @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <div class="p-12 text-center text-gray-500">
                            <div class="w-16 h-16 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-medium">No recent activity</p>
                            <p class="text-sm">Start working on tasks to see your progress here</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Success Message -->
        @if($stats['completed_today'] > 0)
        <div class="relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-600 to-blue-600 rounded-3xl p-8 lg:p-12 text-white shadow-2xl mb-16">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-white bg-opacity-5">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white bg-opacity-10 rounded-full animate-pulse"></div>
                <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white bg-opacity-10 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-24 h-24 bg-white bg-opacity-5 rounded-full animate-pulse" style="animation-delay: 2s;"></div>
            </div>
            
            <!-- Content -->
            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center">
                <div class="w-24 h-24 lg:w-32 lg:h-32 bg-white bg-opacity-20 backdrop-blur-sm rounded-3xl flex items-center justify-center mr-8 shadow-2xl mb-6 lg:mb-0">
                    <div class="relative">
                        <svg class="w-12 h-12 lg:w-16 lg:h-16 text-yellow-300 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-yellow-400 rounded-full animate-ping"></div>
                    </div>
                </div>
                <div class="flex-1">
                    <div class="flex flex-col lg:flex-row lg:items-center mb-4">
                        <h3 class="text-3xl lg:text-4xl font-bold mr-4 mb-2 lg:mb-0">Fantastic Work!</h3>
                        <div class="flex">
                            @for($i = 0; $i < min($stats['completed_today'], 5); $i++)
                            <svg class="w-6 h-6 text-yellow-300 animate-bounce mr-1" style="animation-delay: {{ $i * 0.1 }}s;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xl lg:text-2xl opacity-95 leading-relaxed mb-6">
                        You have successfully completed
                        <span class="font-bold text-yellow-300 text-2xl lg:text-3xl">{{ $stats['completed_today'] }}</span> 
                        out of <span class="font-bold text-yellow-300 text-2xl lg:text-3xl">{{ $stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress'] }}</span> tasks today!
                        @if($stats['completed_today'] >= 5)
                            <span class="block mt-2 text-yellow-200 font-semibold">You're absolutely on fire! 🔥</span>
                        @elseif($stats['completed_today'] >= 3)
                            <span class="block mt-2 text-yellow-200 font-semibold">Amazing productivity! ⚡</span>
                        @else
                            <span class="block mt-2 text-yellow-200 font-semibold">Great start! Keep it up! 💪</span>
                        @endif
                    </p>
                    <div class="flex items-center text-emerald-100">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span class="text-lg font-semibold">Keep up the incredible momentum!</span>
                    </div>
                </div>
            </div>
            
            <!-- Progress Indicator -->
            <div class="mt-8 relative">
                <div class="w-full bg-white bg-opacity-20 rounded-full h-3 shadow-inner">
                    <div class="bg-gradient-to-r from-yellow-400 to-orange-400 h-3 rounded-full transition-all duration-1000 ease-out shadow-lg" 
                         style="width: {{ ($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']) > 0 ? (($stats['completed_today'] / ($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress'])) * 100) : 0 }}%"></div>
                </div>
                <p class="text-sm text-emerald-100 mt-3 text-center font-semibold">
                    {{ round(($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress']) > 0 ? (($stats['completed_today'] / ($stats['pending_tasks'] + $stats['completed_today'] + $stats['in_progress'])) * 100) : 0) }}% of today's tasks completed
                </p>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Enhanced JavaScript -->
<script>
function markNotificationAsRead(notificationId) {
    // Add loading state
    const button = event.target.closest('button');
    const originalContent = button.innerHTML;
    button.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
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
            // Add success animation
            button.innerHTML = '<svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
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

// Auto-refresh every 5 minutes
setInterval(() => {
    if (!document.hidden) {
        location.reload();
    }
}, 5 * 60 * 1000);

// Add smooth scroll behavior
document.documentElement.style.scrollBehavior = 'smooth';

// Add intersection observer for animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards for animation
document.addEventListener('DOMContentLoaded', () => {
    const cards = document.querySelectorAll('.group');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
        observer.observe(card);
    });
});
</script>
@endsection
