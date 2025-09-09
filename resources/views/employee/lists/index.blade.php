@extends('layouts.employee')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">My Task Lists</h1>
                <p class="mt-1 text-sm text-gray-600">View and complete your assigned checklists</p>
            </div>
        </div>
    </div>

    <!-- Filter/Sort Options -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Filter by Priority:</label>
                    <select onchange="window.location.href='{{ route('employee.lists.index') }}?priority=' + this.value" class="text-sm border-gray-300 rounded-md">
                        <option value="">All Priorities</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Category:</label>
                    <select onchange="window.location.href='{{ route('employee.lists.index') }}?category=' + this.value" class="text-sm border-gray-300 rounded-md">
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
            <div class="text-sm text-gray-500">
                {{ $assignedLists->count() }} list(s) assigned
            </div>
        </div>
    </div>

    <!-- Task Lists Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($assignedLists as $list)
            @php
                // Check if user has already started/completed this list today
                $existingSubmission = \App\Models\Submission::where('user_id', auth()->id())
                    ->where('list_id', $list->id)
                    ->whereDate('created_at', today())
                    ->first();
            @endphp
            <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <!-- Priority Badge -->
                    <div class="flex justify-between items-start mb-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($list->priority === 'urgent') bg-red-100 text-red-800
                            @elseif($list->priority === 'high') bg-orange-100 text-orange-800
                            @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ ucfirst($list->priority) }}
                        </span>
                        @if($existingSubmission)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($existingSubmission->status === 'completed') bg-green-100 text-green-800
                                @elseif($existingSubmission->status === 'in_progress') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $existingSubmission->status === 'in_progress' ? 'In Progress' : ucfirst($existingSubmission->status) }}
                            </span>
                        @endif
                    </div>

                    <!-- List Title & Description -->
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $list->title }}</h3>
                    @if($list->description)
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($list->description, 100) }}</p>
                    @endif

                    <!-- List Details -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            {{ $list->tasks->count() }} tasks
                        </div>
                        @if($list->category)
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ $list->category }}
                            </div>
                        @endif
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ ucfirst($list->schedule_type) }}
                        </div>
                        @if($list->requires_signature)
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                                Signature required
                            </div>
                        @endif
                    </div>

                    <!-- Progress Bar (if in progress) -->
                    @if($existingSubmission && $existingSubmission->status === 'in_progress')
                        @php
                            $completedTasks = $existingSubmission->submissionTasks->where('status', 'completed')->count();
                            $totalTasks = $existingSubmission->submissionTasks->count();
                            $percentage = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                        @endphp
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 mb-1">
                                <span>Progress</span>
                                <span>{{ $completedTasks }}/{{ $totalTasks }} tasks</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endif

                    <!-- Action Button -->
                    <div class="flex space-x-3">
                        @if($existingSubmission)
                            @if($existingSubmission->status === 'in_progress')
                                <a href="{{ route('employee.submissions.edit', $existingSubmission) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                    Continue
                                </a>
                            @elseif($existingSubmission->status === 'completed')
                                <div class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50">
                                    ✅ Completed
                                </div>
                            @elseif($existingSubmission->status === 'reviewed')
                                <div class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50">
                                    ✅ Approved
                                </div>
                            @elseif($existingSubmission->status === 'rejected')
                                <a href="{{ route('employee.submissions.edit', $existingSubmission) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-red-50">
                                    ❌ Needs Revision
                                </a>
                            @endif
                            <a href="{{ route('employee.lists.show', $list) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                View
                            </a>
                        @else
                            <a href="{{ route('employee.lists.show', $list) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Start Checklist
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No task lists assigned</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request('priority') || request('category'))
                            No task lists match your current filters. <a href="{{ route('employee.lists.index') }}" class="text-indigo-600 hover:text-indigo-500">Clear filters</a>
                        @else
                            You don't have any task lists assigned yet. Check back later or contact your manager.
                        @endif
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Quick Stats -->
    @if($assignedLists->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Assigned</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $assignedLists->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">In Progress</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ \App\Models\Submission::where('user_id', auth()->id())->where('status', 'in_progress')->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Completed Today</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ \App\Models\Submission::where('user_id', auth()->id())->whereDate('completed_at', today())->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">High Priority</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $assignedLists->whereIn('priority', ['urgent', 'high'])->count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection