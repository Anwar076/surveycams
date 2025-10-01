@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $list->title }}</h1>
                <p class="mt-2 text-gray-600">{{ $list->description }}</p>
                <div class="mt-4 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($list->priority === 'urgent') bg-red-100 text-red-800
                        @elseif($list->priority === 'high') bg-orange-100 text-orange-800
                        @elseif($list->priority === 'medium') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ ucfirst($list->priority) }} Priority
                    </span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ ucfirst($list->schedule_type) }}
                    </span>
                    @if($list->category)
                        <span class="text-sm text-gray-500">{{ $list->category }}</span>
                    @endif
                    @if($list->isDailySubList())
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            {{ ucfirst($list->weekday) }}
                        </span>
                    @endif
                    @if($list->requires_signature)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            Signature Required
                        </span>
                    @endif
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($list->is_active) bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $list->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
                @if($list->isMainList() && $list->subLists->count() === 0)
                    <form method="POST" action="{{ route('admin.lists.create-daily-sublists', $list) }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Create Daily Sub-Lists
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.lists.edit', $list) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Edit List
                </a>
                <a href="{{ route('admin.lists.tasks.create', $list) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Add Task
                </a>
            </div>
        </div>
    </div>

    <!-- Tasks Section -->
    @if($list->schedule_type === 'daily' && $list->isMainList() && $list->subLists->count() > 0)
        <!-- Weekly Overview for Daily Schedule -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Weekly Task Overview</h3>
                    <div class="flex space-x-2">
                        <select id="weekday-select" class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @php
                                $weekdays = [
                                    'monday' => 'Monday',
                                    'tuesday' => 'Tuesday', 
                                    'wednesday' => 'Wednesday',
                                    'thursday' => 'Thursday',
                                    'friday' => 'Friday',
                                    'saturday' => 'Saturday',
                                    'sunday' => 'Sunday'
                                ];
                            @endphp
                            
                            @foreach($weekdays as $weekday => $fullName)
                                <option value="{{ $weekday }}">{{ $fullName }}</option>
                            @endforeach
                        </select>
                        <button id="add-task-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Add Task
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <!-- Task Content for Each Day -->
                @foreach($weekdays as $weekday => $fullName)
                    @php
                        $subList = $list->subLists->firstWhere('weekday', $weekday);
                    @endphp
                    
                    <div class="weekday-content mb-8 {{ $loop->first ? '' : 'hidden' }}" data-weekday="{{ $weekday }}">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-medium text-gray-900">{{ $fullName }} Tasks</h4>
                            @if($subList)
                                <span class="text-sm text-gray-500">{{ $subList->tasks->count() }} tasks</span>
                            @else
                                <span class="text-sm text-gray-500">No tasks</span>
                            @endif
                        </div>

                        @if($subList && $subList->tasks->count() > 0)
                            <!-- Existing Tasks -->
                            <div class="space-y-3">
                                @foreach($subList->tasks->sortBy('order_index') as $task)
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center space-x-2">
                                                    <span class="text-xs font-medium text-gray-500">#{{ $task->order_index }}</span>
                                                    <h5 class="text-sm font-medium text-gray-900">{{ $task->title }}</h5>
                                                </div>
                                                @if($task->description)
                                                    <p class="mt-1 text-sm text-gray-600">{{ $task->description }}</p>
                                                @endif
                                                <div class="mt-2 flex items-center space-x-2">
                                                    @if($task->is_required)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                            Required
                                                        </span>
                                                    @endif
                                                    @if($task->requires_signature)
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                            Signature
                                                        </span>
                                                    @endif
                                                    @if($task->required_proof_type !== 'none')
                                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ ucfirst($task->required_proof_type) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="flex space-x-1 ml-2">
                                                <a href="{{ route('admin.tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900 text-xs">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 text-xs">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <!-- Empty State -->
                            <div class="text-center py-8 bg-gray-50 border border-gray-200 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks for {{ $fullName }}</h3>
                                <p class="mt-1 text-sm text-gray-500">Click "Add Task" to add tasks for this day</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <!-- Regular Tasks View -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tasks List -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Tasks ({{ $list->tasks->count() }})</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($list->tasks as $task)
                        <div class="px-6 py-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm font-medium text-gray-500">#{{ $task->order_index }}</span>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $task->title }}</h4>
                                    </div>
                                    @if($task->description)
                                        <p class="mt-1 text-sm text-gray-600">{{ $task->description }}</p>
                                    @endif
                                    <div class="mt-2 flex items-center space-x-2">
                                        @if($task->is_required)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Required
                                            </span>
                                        @endif
                                        @if($task->requires_signature)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                Signature
                                            </span>
                                        @endif
                                        @if($task->required_proof_type !== 'none')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ ucfirst($task->required_proof_type) }}
                                            </span>
                                        @endif
                                        @if($task->assignments->count() > 0)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $task->assignments->count() }} assigned
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.tasks.edit', $task) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by adding a task to this list.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.lists.tasks.create', $list) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Add First Task
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
    @endif

    @if($list->schedule_type !== 'daily' || !$list->isMainList() || $list->subLists->count() === 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- First column is Tasks (above), second column is Assignments & Stats -->
            <div></div> <!-- Empty div to maintain grid structure -->
    @endif

        <!-- Assignments & Stats -->
        <div class="space-y-6">
            <!-- Quick Assign -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Assign</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.lists.assign', $list) }}" class="space-y-4">
                        @csrf
                        
                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Assignment Type</label>
                            <select name="assignment_type" id="assignment_type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="user">Specific Users</option>
                                <option value="department">Department</option>
                                <option value="role">Role</option>
                            </select>
                        </div>

                        <div id="user_selection" class="assignment-option">
                            <label class="block text-sm font-medium text-gray-700">Select Users</label>
                            <select name="user_ids[]" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach(\App\Models\User::where('role', 'employee')->get() as $user)
                                    <option value="{{ $user->id }}" {{ $list->assignments->where('user_id', $user->id)->count() ? 'selected' : '' }}>{{ $user->name }} ({{ $user->department }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="department_selection" class="assignment-option hidden">
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <input type="text" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Cleaning, Operations" value="{{ optional($list->assignments->where('department', '!=', null)->first())->department }}" disabled>
                        </div>

                        <div id="role_selection" class="assignment-option hidden">
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" disabled>
                                <option value="employee" {{ $list->assignments->where('role', 'employee')->count() ? 'selected' : '' }}>Employee</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Assigned Date</label>
                                <input type="date" name="assigned_date" value="{{ today()->format('Y-m-d') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Due Date (Optional)</label>
                                <input type="date" name="due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Assign List
                        </button>
                    </form>
                </div>
            </div>

            <!-- Current Assignments -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Current Assignments</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($list->assignments as $assignment)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    @if($assignment->user)
                                        <p class="text-sm font-medium text-gray-900">{{ $assignment->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $assignment->user->department }}</p>
                                    @elseif($assignment->department)
                                        <p class="text-sm font-medium text-gray-900">Department: {{ $assignment->department }}</p>
                                    @elseif($assignment->role)
                                        <p class="text-sm font-medium text-gray-900">Role: {{ ucfirst($assignment->role) }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400">Assigned: {{ $assignment->assigned_date->format('M j, Y') }}</p>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($assignment->is_active) bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $assignment->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">
                            <p class="text-sm">No assignments yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Submissions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Recent Submissions</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($list->submissions->take(5) as $submission)
                        <div class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $submission->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $submission->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($submission->status === 'completed') bg-yellow-100 text-yellow-800
                                        @elseif($submission->status === 'reviewed') bg-green-100 text-green-800
                                        @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                        {{ ucfirst($submission->status) }}
                                    </span>
                                    <a href="{{ route('admin.submissions.show', $submission) }}" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500">
                            <p class="text-sm">No submissions yet</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex justify-center">
        <a href="{{ route('admin.lists.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            ← Back to Task Lists
        </a>
    </div>
</div>

<script>
// Assignment type switching
document.getElementById('assignment_type').addEventListener('change', function() {
    const options = document.querySelectorAll('.assignment-option');
    options.forEach(option => {
        option.classList.add('hidden');
        // Disable all inputs in hidden sections
        const inputs = option.querySelectorAll('input, select');
        inputs.forEach(input => input.disabled = true);
    });
    
    const selected = this.value + '_selection';
    const selectedOption = document.getElementById(selected);
    if (selectedOption) {
        selectedOption.classList.remove('hidden');
        // Enable inputs in visible section
        const inputs = selectedOption.querySelectorAll('input, select');
        inputs.forEach(input => input.disabled = false);
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Trigger the change event to set initial state
    document.getElementById('assignment_type').dispatchEvent(new Event('change'));
});

// Weekly Task Interface (simplified without drag & drop)
document.addEventListener('DOMContentLoaded', function() {
    // Weekday dropdown switching
    const weekdaySelect = document.getElementById('weekday-select');
    const contents = document.querySelectorAll('.weekday-content');
    
    if (weekdaySelect) {
        weekdaySelect.addEventListener('change', function() {
            const selectedWeekday = this.value;
            
            // Show corresponding content
            contents.forEach(content => {
                content.classList.add('hidden');
            });
            const targetContent = document.querySelector(`[data-weekday="${selectedWeekday}"].weekday-content`);
            if (targetContent) {
                targetContent.classList.remove('hidden');
            }
        });
    }
    
    // Add Task button
    const addTaskBtn = document.getElementById('add-task-btn');
    if (addTaskBtn) {
        addTaskBtn.addEventListener('click', function() {
            // Get selected weekday
            const selectedWeekday = weekdaySelect ? weekdaySelect.value : 'monday';
            
            // Create new task for this weekday
            const url = new URL('{{ route("admin.lists.tasks.create", $list) }}');
            url.searchParams.set('weekday', selectedWeekday);
            window.location.href = url.toString();
        });
    }
});
</script>
@endsection