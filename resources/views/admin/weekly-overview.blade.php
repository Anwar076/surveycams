@extends('layouts.admin')

@section('content')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Enhanced Page Header -->
        <div class="relative overflow-hidden bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl p-8 mb-8 border border-white/30">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-600/5 via-purple-600/5 to-indigo-600/5"></div>
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-400/10 to-purple-400/10 rounded-full -translate-y-20 translate-x-20 blur-3xl"></div>
            <div class="relative">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-5xl font-bold bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent mb-3">
                            Weekly Analytics
                        </h1>
                        <p class="text-xl text-slate-600 font-medium mb-2">Comprehensive performance insights and KPIs</p>
                        <div class="flex items-center space-x-4 text-sm text-slate-500">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                <span>Live Data</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Updated: {{ now()->format('M j, Y g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 rounded-3xl flex items-center justify-center shadow-2xl transform rotate-3 hover:rotate-6 transition-transform duration-500">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Date Range Selector -->
        <div class="mb-8 group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-3xl border border-white/40 hover:shadow-2xl transition-all duration-500 hover:-translate-y-2">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-2">Date Range Selection</h3>
                        <p class="text-slate-600">Select the period for analytics and insights</p>
                    </div>
                    <form method="GET" class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <input type="date" name="start_date" value="{{ \Carbon\Carbon::parse($startDate)->format('Y-m-d') }}" 
                                       class="px-4 py-3 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-base font-medium">
                            </div>
                            <span class="text-slate-500 font-medium">to</span>
                            <div class="relative">
                                <input type="date" name="end_date" value="{{ \Carbon\Carbon::parse($endDate)->format('Y-m-d') }}" 
                                       class="px-4 py-3 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-base font-medium">
                            </div>
                        </div>
                        <button type="submit" class="group/btn relative overflow-hidden inline-flex items-center px-8 py-3 border border-transparent text-base font-semibold rounded-2xl shadow-xl text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover/btn:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-5 h-5 mr-2 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span class="relative z-10">Update Analytics</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Comprehensive KPI Dashboard -->
        @php
            $totalSubmissions = collect($overview)->sum('total_submissions');
            $totalCompleted = collect($overview)->sum('completed');
            $totalInProgress = collect($overview)->sum('in_progress');
            $totalRejected = collect($overview)->sum('rejected');
            $completionRate = $totalSubmissions > 0 ? round(($totalCompleted / $totalSubmissions) * 100, 1) : 0;
            $avgTasksPerEmployee = count($overview) > 0 ? round($totalSubmissions / count($overview), 1) : 0;
            $productivityScore = $completionRate > 80 ? 'Excellent' : ($completionRate > 60 ? 'Good' : ($completionRate > 40 ? 'Fair' : 'Needs Improvement'));
            
            // Calculate additional KPIs
            $totalEmployees = count($overview);
            $activeEmployees = collect($overview)->where('total_submissions', '>', 0)->count();
            $avgCompletionTime = collect($overview)->where('avg_completion_time', '>', 0)->avg('avg_completion_time') ?? 0;
            $onTimeRate = collect($overview)->where('on_time_rate', '>', 0)->avg('on_time_rate') ?? 0;
            $qualityScore = collect($overview)->where('quality_score', '>', 0)->avg('quality_score') ?? 0;
            
            // Weekly trend data
            $weeklyData = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $daySubmissions = \App\Models\Submission::whereDate('created_at', $date)->count();
                $dayCompleted = \App\Models\Submission::whereDate('created_at', $date)->where('status', 'completed')->count();
                $weeklyData[] = [
                    'date' => $date->format('M j'),
                    'submissions' => $daySubmissions,
                    'completed' => $dayCompleted,
                    'rate' => $daySubmissions > 0 ? round(($dayCompleted / $daySubmissions) * 100, 1) : 0
                ];
            }
        @endphp
        
        <!-- Primary KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Submissions -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-wide">Total Tasks</p>
                            <p class="text-4xl font-bold text-slate-900 mt-1">{{ $totalSubmissions }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">All submissions</span>
                        </div>
                        <div class="w-12 h-2 bg-blue-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full transition-all duration-1000" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completion Rate -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-wide">Completion Rate</p>
                            <p class="text-4xl font-bold text-slate-900 mt-1">{{ $completionRate }}%</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-emerald-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">{{ $productivityScore }}</span>
                        </div>
                        <div class="w-12 h-2 bg-emerald-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-emerald-500 to-green-500 rounded-full transition-all duration-1000" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Employees -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-wide">Active Employees</p>
                            <p class="text-4xl font-bold text-slate-900 mt-1">{{ $activeEmployees }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-purple-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Out of {{ $totalEmployees }}</span>
                        </div>
                        <div class="w-12 h-2 bg-purple-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full transition-all duration-1000" style="width: {{ $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quality Score -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-all duration-500">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-wide">Quality Score</p>
                            <p class="text-4xl font-bold text-slate-900 mt-1">{{ round($qualityScore, 1) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-amber-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Out of 5.0</span>
                        </div>
                        <div class="w-12 h-2 bg-amber-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-500 to-yellow-500 rounded-full transition-all duration-1000" style="width: {{ ($qualityScore / 5) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pending Review KPI -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-yellow-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-amber-400/10 to-yellow-400/10 rounded-full -translate-y-10 translate-x-10 blur-2xl"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-slate-600 uppercase tracking-wide">Pending Review</p>
                            <p class="text-4xl font-bold text-slate-900 mt-1">{{ $totalInProgress }}</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-amber-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold">Awaiting approval</span>
                        </div>
                        <div class="w-12 h-2 bg-amber-100 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-500 to-yellow-500 rounded-full transition-all duration-1000" style="width: {{ $totalSubmissions > 0 ? ($totalInProgress / $totalSubmissions) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Weekly Trend Chart -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">Weekly Performance Trend</h3>
                            <p class="text-slate-600">Last 7 days completion rates</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="weeklyTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Task Status Distribution -->
            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/40">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">Task Status Distribution</h3>
                            <p class="text-slate-600">Current task status breakdown</p>
                        </div>
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="h-80">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Metrics Table -->
        <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/40 mb-8">
            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">Performance Metrics</h3>
                        <p class="text-slate-600">Detailed analytics and key performance indicators</p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Completion Rate -->
                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border border-emerald-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-emerald-600">Completion Rate</p>
                                <p class="text-2xl font-bold text-slate-900">{{ $completionRate }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-emerald-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-emerald-500 to-green-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $completionRate }}%"></div>
                        </div>
                    </div>

                    <!-- Average Completion Time -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-blue-600">Avg. Time</p>
                                <p class="text-2xl font-bold text-slate-900">
                                    @if($avgCompletionTime > 0)
                                        @if($avgCompletionTime < 1)
                                            {{ round($avgCompletionTime * 60, 0) }}m
                                        @else
                                            {{ round($avgCompletionTime, 1) }}h
                                        @endif
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="w-full bg-blue-100 rounded-full h-2">
                            @if($avgCompletionTime > 0)
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2 rounded-full transition-all duration-1000" style="width: {{ min(($avgCompletionTime / 8) * 100, 100) }}%"></div>
                            @else
                                <div class="bg-gradient-to-r from-gray-300 to-gray-400 h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                            @endif
                        </div>
                    </div>

                    <!-- On-Time Rate -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-purple-600">On-Time Rate</p>
                                <p class="text-2xl font-bold text-slate-900">{{ round($onTimeRate, 1) }}%</p>
                            </div>
                        </div>
                        <div class="w-full bg-purple-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $onTimeRate }}%"></div>
                        </div>
                    </div>

                    <!-- Quality Score -->
                    <div class="bg-gradient-to-br from-amber-50 to-yellow-50 rounded-2xl p-6 border border-amber-200">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-amber-600">Quality Score</p>
                                <p class="text-2xl font-bold text-slate-900">{{ round($qualityScore, 1) }}/5</p>
                            </div>
                        </div>
                        <div class="w-full bg-amber-100 rounded-full h-2">
                            <div class="bg-gradient-to-r from-amber-500 to-yellow-500 h-2 rounded-full transition-all duration-1000" style="width: {{ ($qualityScore / 5) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Employee Performance Analytics -->
        <div class="mt-12 group relative overflow-hidden bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/30 hover:shadow-3xl transition-all duration-700 hover:-translate-y-3">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 via-teal-500/5 to-cyan-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-emerald-400/10 to-teal-400/10 rounded-full -translate-y-20 translate-x-20 blur-3xl"></div>
            <div class="relative p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-emerald-900 to-teal-900 bg-clip-text text-transparent">Employee Performance</h3>
                        <p class="text-lg text-slate-600 font-medium mt-2">Individual performance metrics and completion rates</p>
                    </div>
                    <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-600 rounded-3xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200/50">
                        <thead class="bg-gradient-to-r from-slate-50/80 to-blue-50/80">
                            <tr>
                                <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Employee</th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Total Tasks</th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Completed</th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">In Progress</th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Rejected</th>
                                <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Completion Rate</th>
                                <th class="px-8 py-6 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white/50 divide-y divide-slate-200/50">
                            @forelse($overview as $data)
                                @php
                                    $completionRate = $data['completion_rate'];
                                    $performanceColor = $completionRate >= 80 ? 'emerald' : ($completionRate >= 60 ? 'blue' : ($completionRate >= 40 ? 'amber' : 'red'));
                                @endphp
                                <tr class="group/row hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 transition-all duration-300">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <div class="relative">
                                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg group-hover/row:scale-110 transition-transform duration-300">
                                                    <span class="text-white font-bold text-lg">{{ substr($data['employee']->name, 0, 2) }}</span>
                                                </div>
                                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full border-2 border-white"></div>
                                            </div>
                                            <div>
                                                <div class="text-base font-bold text-slate-900 group-hover/row:text-emerald-600 transition-colors duration-200">{{ $data['employee']->name }}</div>
                                                <div class="text-sm text-slate-500">{{ $data['employee']->department ?? 'No Department' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-lg font-bold text-slate-900">{{ $data['total_submissions'] }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200">
                                            {{ $data['completed'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200">
                                            {{ $data['in_progress'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200">
                                            {{ $data['rejected'] }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <div class="text-right">
                                                <div class="text-xl font-bold text-slate-900">{{ $completionRate }}%</div>
                                                <div class="text-xs text-slate-500">completion rate</div>
                                            </div>
                                            <div class="w-20 h-3 bg-slate-200 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-{{ $performanceColor }}-500 to-{{ $performanceColor }}-600 rounded-full transition-all duration-1000" style="width: {{ $completionRate }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-right">
                                        <a href="{{ route('admin.users.show', $data['employee']) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-sm font-semibold rounded-xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                                            View Details
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-8 py-16 text-center">
                                        <div class="relative w-24 h-24 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                                            <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-3xl"></div>
                                        </div>
                                        <p class="text-slate-500 font-bold text-xl">No employee data available</p>
                                        <p class="text-slate-400 text-base mt-2">Employee performance will appear here for the selected period</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($overview as $data)
                        @php
                            $completionRate = $data['completion_rate'];
                            $performanceColor = $completionRate >= 80 ? 'emerald' : ($completionRate >= 60 ? 'blue' : ($completionRate >= 40 ? 'amber' : 'red'));
                        @endphp
                        <div class="group/employee relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-3 border border-white/40">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-teal-500/5 opacity-0 group-hover/employee:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-400/10 to-teal-400/10 rounded-full -translate-y-10 translate-x-10 blur-2xl"></div>
                            <div class="relative p-6">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="relative">
                                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 via-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg group-hover/employee:scale-110 group-hover/employee:rotate-12 transition-all duration-500">
                                            <span class="text-white font-bold text-xl">{{ substr($data['employee']->name, 0, 2) }}</span>
                                        </div>
                                        <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-r from-emerald-400 to-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-3xl font-bold text-slate-900">{{ $completionRate }}%</p>
                                        <p class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Completion Rate</p>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <p class="text-lg font-bold text-slate-900 truncate group-hover/employee:text-emerald-600 transition-colors duration-200">{{ $data['employee']->name }}</p>
                                    <p class="text-sm text-slate-500 mt-1">{{ $data['employee']->department ?? 'No Department' }}</p>
                                </div>
                                <div class="grid grid-cols-3 gap-4 mb-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-slate-900">{{ $data['total_submissions'] }}</div>
                                        <div class="text-xs text-slate-500">Total</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-emerald-600">{{ $data['completed'] }}</div>
                                        <div class="text-xs text-slate-500">Completed</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-amber-600">{{ $data['in_progress'] }}</div>
                                        <div class="text-xs text-slate-500">In Progress</div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center text-sm text-emerald-600">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-semibold">Performance</span>
                                    </div>
                                    <div class="w-16 h-3 bg-slate-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-{{ $performanceColor }}-500 to-{{ $performanceColor }}-600 rounded-full transition-all duration-1000" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-20">
                            <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-teal-500/10 rounded-3xl"></div>
                            </div>
                            <p class="text-slate-500 font-bold text-2xl">No employee data available</p>
                            <p class="text-slate-400 text-lg mt-2">Employee performance will appear here for the selected period</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Enhanced Daily Breakdown Chart -->
        <div class="mt-12 group relative overflow-hidden bg-white/90 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/30 hover:shadow-3xl transition-all duration-700 hover:-translate-y-3">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 via-purple-500/5 to-pink-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
            <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-indigo-400/10 to-purple-400/10 rounded-full -translate-y-20 translate-x-20 blur-3xl"></div>
            <div class="relative p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-4xl font-bold bg-gradient-to-r from-slate-900 via-indigo-900 to-purple-900 bg-clip-text text-transparent">Daily Task Completion</h3>
                        <p class="text-lg text-slate-600 font-medium mt-2">Task submission trends over the selected period</p>
                    </div>
                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-600 rounded-3xl flex items-center justify-center shadow-2xl group-hover:scale-110 group-hover:rotate-12 transition-all duration-500">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                
                @php
                    $days = [];
                    $currentDate = \Carbon\Carbon::parse($startDate)->copy();
                    while ($currentDate <= \Carbon\Carbon::parse($endDate)) {
                        $daySubmissions = 0;
                        foreach ($overview as $data) {
                            $daySubmissions += $data['submissions']->filter(function($submission) use ($currentDate) {
                                return $submission->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
                            })->count();
                        }
                        $days[] = [
                            'date' => $currentDate->copy(),
                            'count' => $daySubmissions
                        ];
                        $currentDate->addDay();
                    }
                    $maxCount = collect($days)->max('count') ?: 1;
                @endphp
                
                <!-- Daily Chart Container -->
                <div class="h-80 bg-gradient-to-t from-slate-50/50 to-white/50 rounded-2xl p-6 border border-slate-200/50">
                    <!-- Always Show Colored Bar Chart -->
                    <div class="h-full flex items-end justify-between space-x-2">
                        @if(isset($days) && count($days) > 0)
                            @foreach($days as $day)
                                <div class="flex flex-col items-center space-y-3 flex-1 group/bar">
                                    @if($day['count'] > 0)
                                        <!-- Bar with Data - Colorful -->
                                        <div class="w-full bg-gradient-to-t from-indigo-200 to-indigo-100 rounded-t-2xl transition-all duration-500 group-hover/bar:from-indigo-300 group-hover/bar:to-indigo-200 relative" 
                                             style="height: {{ $maxCount > 0 ? ($day['count'] / $maxCount) * 240 : 0 }}px">
                                            <div class="w-full bg-gradient-to-t from-indigo-600 via-purple-600 to-pink-600 rounded-t-2xl h-full flex items-end justify-center pb-2 transition-all duration-500 group-hover/bar:from-indigo-700 group-hover/bar:via-purple-700 group-hover/bar:to-pink-700">
                                                <span class="text-white text-sm font-bold bg-black/20 px-2 py-1 rounded-lg backdrop-blur-sm">{{ $day['count'] }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <!-- Empty Bar - Still Colorful -->
                                        <div class="w-full bg-gradient-to-t from-blue-200 to-blue-100 rounded-t-2xl transition-all duration-500 group-hover/bar:from-blue-300 group-hover/bar:to-blue-200 relative" 
                                             style="height: 40px">
                                            <div class="w-full bg-gradient-to-t from-blue-400 via-blue-500 to-blue-600 rounded-t-2xl h-full flex items-center justify-center transition-all duration-500 group-hover/bar:from-blue-500 group-hover/bar:via-blue-600 group-hover/bar:to-blue-700">
                                                <span class="text-white text-xs font-bold">0</span>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <div class="text-sm font-bold text-slate-900">{{ \Carbon\Carbon::parse($day['date'])->format('M j') }}</div>
                                        <div class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($day['date'])->format('D') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback Chart with Sample Data -->
                            @php
                                $sampleDays = [
                                    ['date' => now()->subDays(6), 'count' => 0],
                                    ['date' => now()->subDays(5), 'count' => 0],
                                    ['date' => now()->subDays(4), 'count' => 0],
                                    ['date' => now()->subDays(3), 'count' => 0],
                                    ['date' => now()->subDays(2), 'count' => 0],
                                    ['date' => now()->subDays(1), 'count' => 0],
                                    ['date' => now(), 'count' => 0],
                                ];
                            @endphp
                            @foreach($sampleDays as $day)
                                <div class="flex flex-col items-center space-y-3 flex-1 group/bar">
                                    <!-- Empty Bar - Still Colorful -->
                                    <div class="w-full bg-gradient-to-t from-blue-200 to-blue-100 rounded-t-2xl transition-all duration-500 group-hover/bar:from-blue-300 group-hover/bar:to-blue-200 relative" 
                                         style="height: 40px">
                                        <div class="w-full bg-gradient-to-t from-blue-400 via-blue-500 to-blue-600 rounded-t-2xl h-full flex items-center justify-center transition-all duration-500 group-hover/bar:from-blue-500 group-hover/bar:via-blue-600 group-hover/bar:to-blue-700">
                                            <span class="text-white text-xs font-bold">0</span>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-sm font-bold text-slate-900">{{ $day['date']->format('M j') }}</div>
                                        <div class="text-xs text-slate-500">{{ $day['date']->format('D') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                
                <!-- Chart Summary -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl border border-indigo-200">
                        <div class="text-2xl font-bold text-indigo-600">{{ collect($days)->sum('count') }}</div>
                        <div class="text-sm text-slate-600">Total Submissions</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-200">
                        <div class="text-2xl font-bold text-purple-600">{{ collect($days)->avg('count') > 0 ? round(collect($days)->avg('count'), 1) : 0 }}</div>
                        <div class="text-sm text-slate-600">Daily Average</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-pink-50 to-rose-50 rounded-2xl border border-pink-200">
                        <div class="text-2xl font-bold text-pink-600">{{ collect($days)->max('count') }}</div>
                        <div class="text-sm text-slate-600">Peak Day</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Weekly Trend Chart
    const weeklyTrendCtx = document.getElementById('weeklyTrendChart');
    if (weeklyTrendCtx) {
        new Chart(weeklyTrendCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(collect($weeklyData)->pluck('date')) !!},
                datasets: [{
                    label: 'Submissions',
                    data: {!! json_encode(collect($weeklyData)->pluck('submissions')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Completed',
                    data: {!! json_encode(collect($weeklyData)->pluck('completed')) !!},
                    borderColor: 'rgb(16, 185, 129)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });
    }

    // Status Distribution Chart
    const statusDistributionCtx = document.getElementById('statusDistributionChart');
    if (statusDistributionCtx) {
        new Chart(statusDistributionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'In Progress', 'Rejected'],
                datasets: [{
                    data: [{{ $totalCompleted }}, {{ $totalInProgress }}, {{ $totalRejected }}],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderColor: [
                        'rgb(16, 185, 129)',
                        'rgb(245, 158, 11)',
                        'rgb(239, 68, 68)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: false
                    }
                }
            }
        });
    }

});
</script>
@endsection