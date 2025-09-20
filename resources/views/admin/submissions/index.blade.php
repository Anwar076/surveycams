@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modern Page Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-4xl font-bold leading-tight bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent">
                        All Submissions
                    </h1>
                    <p class="mt-3 text-lg text-slate-600 font-medium">
                        Review and manage task submissions from employees
                    </p>
                </div>
                <div class="mt-6 flex md:ml-4 md:mt-0">
                    <!-- Enhanced Filter Form -->
                    <form method="GET" class="flex items-center space-x-3">
                        <select name="status" class="px-4 py-3 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-base font-medium">
                            <option value="">All Status</option>
                            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="reviewed" {{ request('status') === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="group inline-flex items-center px-6 py-3 border border-transparent text-base font-semibold rounded-2xl shadow-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                            </svg>
                            Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            @php
                $totalSubmissions = $submissions->total();
                $inProgress = \App\Models\Submission::where('status', 'in_progress')->count();
                $completed = \App\Models\Submission::where('status', 'completed')->count();
                $reviewed = \App\Models\Submission::where('status', 'reviewed')->count();
            @endphp
            
            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Total Submissions</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $totalSubmissions }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-blue-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">All submissions</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-500/10 to-amber-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">In Progress</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $inProgress }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-yellow-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Active work</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-green-500/10 to-emerald-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Completed</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $completed }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-green-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Ready for review</span>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Reviewed</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $reviewed }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-indigo-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Approved</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Submissions List -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/50 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-200/50 bg-gradient-to-r from-slate-50/80 to-blue-50/80">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Submissions</h3>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            {{ $submissions->total() }} submissions
                        </span>
                    </div>
                </div>
            </div>

            @if($submissions->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden lg:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200/50">
                            <thead class="bg-gradient-to-r from-slate-50/80 to-blue-50/80">
                                <tr>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Employee</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Task List</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Progress</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Started</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Completed</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-slate-200/50">
                                @forelse($submissions as $submission)
                                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                                        <td class="px-8 py-8">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                        <span class="text-white font-bold text-lg">{{ substr($submission->user->name, 0, 2) }}</span>
                                                    </div>
                                                </div>
                                                <div class="ml-6">
                                                    <div class="text-lg font-bold text-slate-900 group-hover:text-indigo-600 transition-colors duration-200">{{ $submission->user->name }}</div>
                                                    <div class="text-sm text-slate-600">{{ $submission->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-8">
                                            <div class="text-lg font-bold text-slate-900">{{ $submission->taskList->title }}</div>
                                            <div class="text-sm text-slate-600">{{ $submission->taskList->category ?? 'No category' }}</div>
                                        </td>
                                        <td class="px-8 py-8">
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold shadow-sm
                                                @if($submission->status === 'completed') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                                                @elseif($submission->status === 'reviewed') bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                                @elseif($submission->status === 'rejected') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                                                @else bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200 @endif">
                                                {{ ucfirst($submission->status) }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-8">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 mr-3">
                                                    <span class="text-lg font-bold text-slate-900">{{ $submission->completion_percentage }}%</span>
                                                </div>
                                                <div class="flex-1 bg-slate-200 rounded-full h-3 max-w-24">
                                                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500" style="width: {{ $submission->completion_percentage }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-8 text-sm text-slate-600">
                                            {{ $submission->started_at ? $submission->started_at->format('M j, Y g:i A') : $submission->created_at->format('M j, Y g:i A') }}
                                        </td>
                                        <td class="px-8 py-8 text-sm text-slate-600">
                                            {{ $submission->completed_at ? $submission->completed_at->format('M j, Y g:i A') : '-' }}
                                        </td>
                                        <td class="px-8 py-8 text-right">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('admin.submissions.show', $submission) }}" 
                                                   class="group/action inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 hover:shadow-lg">
                                                    <svg class="w-4 h-4 mr-2 group-hover/action:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                @if($submission->status === 'completed')
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                                                        Ready for Review
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-8 py-20 text-center text-slate-500">
                                            <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                                                <svg class="w-16 h-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                </svg>
                                                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-3xl"></div>
                                            </div>
                                            <h3 class="text-2xl font-bold text-slate-900 mb-3">No submissions</h3>
                                            <p class="text-slate-600 max-w-md mx-auto text-lg leading-relaxed">No submissions match your current filter criteria.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-slate-200/50">
                    @foreach($submissions as $submission)
                        <div class="p-8 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                            <div class="flex items-start space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">{{ substr($submission->user->name, 0, 2) }}</span>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-900 mb-1">{{ $submission->user->name }}</h4>
                                            <p class="text-sm text-slate-600 mb-2">{{ $submission->user->email }}</p>
                                            <h5 class="text-lg font-semibold text-slate-800 mb-2">{{ $submission->taskList->title }}</h5>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-semibold 
                                            @if($submission->status === 'completed') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                                            @elseif($submission->status === 'reviewed') bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                            @elseif($submission->status === 'rejected') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                                            @else bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200 @endif">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="mt-4 flex items-center justify-between text-sm text-slate-600 mb-4">
                                        <span class="font-semibold">{{ $submission->completion_percentage }}% complete</span>
                                        <span class="font-semibold">{{ $submission->taskList->category ?? 'No category' }}</span>
                                    </div>

                                    <div class="flex items-center justify-between text-xs text-slate-500 mb-6">
                                        <span>Started: {{ $submission->started_at ? $submission->started_at->format('M j, Y') : $submission->created_at->format('M j, Y') }}</span>
                                        <span>Completed: {{ $submission->completed_at ? $submission->completed_at->format('M j, Y') : '-' }}</span>
                                    </div>

                                    <div class="flex space-x-4">
                                        <a href="{{ route('admin.submissions.show', $submission) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">View Details</a>
                                        @if($submission->status === 'completed')
                                            <span class="text-green-600 text-sm font-semibold">Ready for Review</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-20">
                    <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                        <svg class="w-16 h-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-3xl"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">No submissions</h3>
                    <p class="text-slate-600 max-w-md mx-auto text-lg leading-relaxed">No submissions match your current filter criteria.</p>
                </div>
            @endif
        </div>

        <!-- Enhanced Pagination -->
        @if($submissions->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 px-8 py-4">
                    {{ $submissions->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
