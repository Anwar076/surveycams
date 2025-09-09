@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Task List</h1>
                <p class="mt-1 text-sm text-gray-600">Update the details of "{{ $list->title }}"</p>
            </div>
            <a href="{{ route('admin.lists.show', $list) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.lists.update', $list) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title', $list->title) }}" placeholder="e.g., Daily Office Cleaning">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Describe what this task list is for...">{{ old('description', $list->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('category', $list->category) }}" placeholder="e.g., Cleaning, Safety, Maintenance">
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority <span class="text-red-500">*</span></label>
                    <select name="priority" id="priority" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="low" {{ old('priority', $list->priority) === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $list->priority) === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $list->priority) === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority', $list->priority) === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="schedule_type" class="block text-sm font-medium text-gray-700">Schedule Type <span class="text-red-500">*</span></label>
                    <select name="schedule_type" id="schedule_type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="once" {{ old('schedule_type', $list->schedule_type) === 'once' ? 'selected' : '' }}>One-time</option>
                        <option value="daily" {{ old('schedule_type', $list->schedule_type) === 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('schedule_type', $list->schedule_type) === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('schedule_type', $list->schedule_type) === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="custom" {{ old('schedule_type', $list->schedule_type) === 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    @error('schedule_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Additional Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date (Optional)</label>
                    <input type="datetime-local" name="due_date" id="due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('due_date', $list->due_date?->format('Y-m-d\TH:i')) }}">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="parent_list_id" class="block text-sm font-medium text-gray-700">Parent List (Optional)</label>
                    <select name="parent_list_id" id="parent_list_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">None - This is a main list</option>
                        @foreach($parentLists as $parentList)
                            <option value="{{ $parentList->id }}" {{ old('parent_list_id', $list->parent_list_id) == $parentList->id ? 'selected' : '' }}>
                                {{ $parentList->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_list_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Checkboxes -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="requires_signature" id="requires_signature" value="1" {{ old('requires_signature', $list->requires_signature) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="requires_signature" class="ml-2 block text-sm text-gray-900">
                        Require digital signature upon completion
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_template" id="is_template" value="1" {{ old('is_template', $list->is_template) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_template" class="ml-2 block text-sm text-gray-900">
                        Save as template (can be reused for creating similar lists)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $list->is_active) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (employees can see and complete this list)
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.lists.show', $list) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Update Task List
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white shadow rounded-lg border border-red-200">
        <div class="px-6 py-4 border-b border-red-200">
            <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
        </div>
        <div class="p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h4 class="text-sm font-medium text-red-900">Delete Task List</h4>
                    <p class="text-sm text-red-700">Once you delete this task list, there is no going back. This will also delete all associated tasks and submissions.</p>
                </div>
                <form method="POST" action="{{ route('admin.lists.destroy', $list) }}" onsubmit="return confirm('Are you sure you want to delete this task list? This action cannot be undone and will delete all associated tasks and submissions.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-red-300 text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                        Delete List
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection