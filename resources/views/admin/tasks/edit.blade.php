@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Task</h1>
                <p class="mt-1 text-sm text-gray-600">Edit "{{ $task->title }}" in "{{ $task->taskList->title }}"</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.lists.show', $task->taskList) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this task?')" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Delete Task
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.tasks.update', $task) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Task Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title', $task->title) }}" placeholder="e.g., Empty all trash bins">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Provide a clear description of what needs to be done...">{{ old('description', $task->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700">Detailed Instructions</label>
                    <textarea name="instructions" id="instructions" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Provide step-by-step instructions on how to complete this task...">{{ old('instructions', $task->instructions) }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">These instructions will be shown to employees when they're completing the task.</p>
                    @error('instructions')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Task Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="required_proof_type" class="block text-sm font-medium text-gray-700">Required Proof Type <span class="text-red-500">*</span></label>
                    <select name="required_proof_type" id="required_proof_type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="none" {{ old('required_proof_type', $task->required_proof_type) === 'none' ? 'selected' : '' }}>No proof required</option>
                        <option value="photo" {{ old('required_proof_type', $task->required_proof_type) === 'photo' ? 'selected' : '' }}>Photo required</option>
                        <option value="video" {{ old('required_proof_type', $task->required_proof_type) === 'video' ? 'selected' : '' }}>Video required</option>
                        <option value="text" {{ old('required_proof_type', $task->required_proof_type) === 'text' ? 'selected' : '' }}>Text note required</option>
                        <option value="file" {{ old('required_proof_type', $task->required_proof_type) === 'file' ? 'selected' : '' }}>File upload required</option>
                        <option value="any" {{ old('required_proof_type', $task->required_proof_type) === 'any' ? 'selected' : '' }}>Any proof type</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Choose what type of proof employees must provide to complete this task.</p>
                    @error('required_proof_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order_index" class="block text-sm font-medium text-gray-700">Order Position</label>
                    <input type="number" name="order_index" id="order_index" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('order_index', $task->order_index) }}" placeholder="1">
                    <p class="mt-1 text-sm text-gray-500">The order in which this task should appear in the list.</p>
                    @error('order_index')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Task Options -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_required" id="is_required" value="1" {{ old('is_required', $task->is_required) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_required" class="ml-2 block text-sm text-gray-900">
                        Required task (must be completed before submission)
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="requires_signature" id="requires_signature" value="1" {{ old('requires_signature', $task->requires_signature) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="requires_signature" class="ml-2 block text-sm text-gray-900">
                        Requires digital signature for completion
                    </label>
                </div>
            </div>

            <!-- Task Assignment -->
            <div>
                <label for="assigned_users" class="block text-sm font-medium text-gray-700">Assign to Specific Users</label>
                <select name="assigned_users[]" id="assigned_users" multiple class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" size="5">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('assigned_users', $assignedUsers ?? [])) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple users. Leave empty to assign to all employees with list access.</p>
                @error('assigned_users')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Assignments -->
            @if($task->assignments->count() > 0)
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Currently Assigned To:</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($task->assignments as $assignment)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                            {{ $assignment->user->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.lists.show', $task->taskList) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Update Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
