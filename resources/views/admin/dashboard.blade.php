@extends('layouts.admin')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Modern Page Header with Glass Effect -->
            <div
                class="relative overflow-hidden bg-white/80 backdrop-blur-xl shadow-2xl rounded-3xl p-8 mb-8 border border-white/20">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 via-purple-600/10 to-indigo-600/10"></div>
                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1
                                class="text-4xl font-bold bg-gradient-to-r from-gray-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent">
                                Admin Dashboard
                            </h1>
                            <p class="mt-3 text-lg text-gray-600 font-medium">Comprehensive overview of your task management
                                ecosystem</p>
                        </div>
                        <div class="hidden md:block">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Statistics Cards with Animations -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Employees Card -->
                <div
                    class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Employees
                                    </p>
                                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_employees'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Active workforce</span>
                        </div>
                    </div>
                </div>

                <!-- Active Lists Card -->
                <div
                    class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-green-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Active Lists</p>
                                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_lists'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-emerald-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">In progress</span>
                        </div>
                    </div>
                </div>

                <!-- Pending Review Card -->
                <div
                    class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pending Review
                                    </p>
                                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['pending_submissions'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-amber-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Awaiting approval</span>
                        </div>
                    </div>
                </div>

                <!-- Completed Today Card -->
                <div
                    class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Completed Today
                                    </p>
                                    <p class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['completed_today'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center text-sm text-purple-600">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Tasks finished</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analytics & Insights Section -->
            <div class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Activity Feed -->
                <div
                    class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/40 hover:shadow-3xl transition-all duration-700 hover:-translate-y-3">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/10 via-cyan-500/5 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-cyan-400/20 rounded-full -translate-y-16 translate-x-16 blur-2xl">
                    </div>
                    <div class="relative p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3
                                    class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                    Recent Activity</h3>
                                <p class="text-sm text-gray-500 mt-1">Latest submissions and updates</p>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-blue-500 via-cyan-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-5">
                            @forelse($recentSubmissions as $submission)
                                <div
                                    class="group/item relative flex items-center space-x-5 p-5 bg-gradient-to-r from-gray-50/80 to-white/80 rounded-2xl hover:from-blue-50/80 hover:to-cyan-50/80 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] border border-gray-100/50">
                                    <div class="relative">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover/item:scale-110 transition-transform duration-300">
                                            <span
                                                class="text-white font-bold text-sm">{{ substr($submission->user->name, 0, 1) }}</span>
                                        </div>
                                        <div
                                            class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full border-2 border-white">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-bold text-gray-900 truncate group-hover/item:text-indigo-600 transition-colors duration-200">
                                            {{ $submission->taskList->title }}</p>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center space-x-2">
                                            <span>{{ $submission->user->name }}</span>
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span>{{ $submission->created_at->diffForHumans() }}</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span
                                            class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold shadow-sm
                                                @if($submission->status === 'completed') bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200
                                                @elseif($submission->status === 'reviewed') bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200
                                                @else bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 @endif">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                        <a href="{{ route('admin.submissions.show', $submission) }}"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-semibold rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                                            Review
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div
                                        class="relative w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                            </path>
                                        </svg>
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 rounded-3xl">
                                        </div>
                                    </div>
                                    <p class="text-gray-500 font-semibold text-lg">No recent activity</p>
                                    <p class="text-gray-400 text-sm mt-2">Activity will appear here as users submit tasks</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Employee Performance Analytics -->
                <div
                    class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/40 hover:shadow-3xl transition-all duration-700 hover:-translate-y-3">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 via-teal-500/5 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-400/20 to-teal-400/20 rounded-full -translate-y-16 translate-x-16 blur-2xl">
                    </div>
                    <div class="relative p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3
                                    class="text-2xl font-bold bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                    Team Performance</h3>
                                <p class="text-sm text-gray-500 mt-1">30-day completion analytics</p>
                            </div>
                            <div
                                class="w-14 h-14 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-4">
                            @forelse($employeeStats as $employee)
                                <div
                                    class="group/employee relative flex items-center space-x-4 p-4 bg-gradient-to-r from-gray-50/80 to-white/80 rounded-2xl hover:from-emerald-50/80 hover:to-teal-50/80 transition-all duration-300 hover:shadow-lg hover:scale-[1.02] border border-gray-100/50">
                                    <div class="relative">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg group-hover/employee:scale-110 transition-transform duration-300">
                                            <span
                                                class="text-white font-bold text-sm">{{ substr($employee->name, 0, 1) }}</span>
                                        </div>
                                        <div
                                            class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full border-2 border-white">
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="text-sm font-bold text-gray-900 truncate group-hover/employee:text-emerald-600 transition-colors duration-200">
                                            {{ $employee->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1 flex items-center space-x-2">
                                            <span>{{ $employee->department }}</span>
                                            <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                            <span>{{ $employee->completed_submissions }}/{{ $employee->total_submissions }}
                                                tasks</span>
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900">{{ $employee->completion_rate }}%</p>
                                            <p class="text-xs text-gray-500">completion rate</p>
                                        </div>
                                        <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-500"
                                                style="width: {{ $employee->completion_rate }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div
                                        class="relative w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                            </path>
                                        </svg>
                                        <div
                                            class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-3xl">
                                        </div>
                                    </div>
                                    <p class="text-gray-500 font-semibold text-lg">No employee data</p>
                                    <p class="text-gray-400 text-sm mt-2">Employee performance will appear here</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>


                <!-- Quick Actions -->
                <div
                    class="bg-gradient-to-br from-white via-gray-50/50 to-white shadow-xl rounded-3xl p-8 border border-gray-100/50 w-full">
                    <div class="flex items-center space-x-3 mb-8">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Quick Actions</h3>
                            <p class="text-sm text-gray-500">Manage your workspace efficiently</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full">
                        <a href="{{ route('admin.lists.create') }}"
                            class="group relative overflow-hidden bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="relative z-10">
                                <div
                                    class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg mb-2">Create New List</h4>
                                <p class="text-white/80 text-sm">Start a new task list for your team</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.submissions.index') }}"
                            class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl p-6 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="relative z-10">
                                <div
                                    class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg mb-2">Review Submissions</h4>
                                <p class="text-white/80 text-sm">Check and approve team submissions</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.create') }}"
                            class="group relative overflow-hidden bg-gradient-to-br from-amber-500 via-orange-500 to-red-500 rounded-2xl p-6 text-white hover:shadow-2xl hover:scale-105 transition-all duration-300 w-full">
                            <div
                                class="absolute inset-0 bg-gradient-to-br from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                            <div class="relative z-10">
                                <div
                                    class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-lg mb-2">Add User</h4>
                                <p class="text-white/80 text-sm">Invite new team members</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
@endsection