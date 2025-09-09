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
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($list->is_active) bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ $list->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="flex space-x-3">
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
                                    @if($task->required_proof_type !== 'none')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($task->required_proof_type) }}
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
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->department }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div id="department_selection" class="assignment-option hidden">
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <input type="text" name="department" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g., Cleaning, Operations">
                        </div>

                        <div id="role_selection" class="assignment-option hidden">
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="employee">Employee</option>
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
document.getElementById('assignment_type').addEventListener('change', function() {
    const options = document.querySelectorAll('.assignment-option');
    options.forEach(option => option.classList.add('hidden'));
    
    const selected = this.value + '_selection';
    const selectedOption = document.getElementById(selected);
    if (selectedOption) {
        selectedOption.classList.remove('hidden');
    }
});
</script>
@endsection