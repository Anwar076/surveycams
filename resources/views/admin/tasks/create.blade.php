@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add Task</h1>
                <p class="mt-1 text-sm text-gray-600">Add a new task to "{{ $list->title }}"</p>
            </div>
            <a href="{{ route('admin.lists.show', $list) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.lists.tasks.store', $list) }}" class="space-y-6 p-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Task Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title') }}" placeholder="e.g., Empty all trash bins">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Provide a clear description of what needs to be done...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700">Detailed Instructions</label>
                    <textarea name="instructions" id="instructions" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Provide step-by-step instructions on how to complete this task...">{{ old('instructions') }}</textarea>
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
                        <option value="none" {{ old('required_proof_type', 'none') === 'none' ? 'selected' : '' }}>No proof required</option>
                        <option value="photo" {{ old('required_proof_type') === 'photo' ? 'selected' : '' }}>Photo required</option>
                        <option value="video" {{ old('required_proof_type') === 'video' ? 'selected' : '' }}>Video required</option>
                        <option value="text" {{ old('required_proof_type') === 'text' ? 'selected' : '' }}>Text note required</option>
                        <option value="file" {{ old('required_proof_type') === 'file' ? 'selected' : '' }}>File upload required</option>
                        <option value="any" {{ old('required_proof_type') === 'any' ? 'selected' : '' }}>Any proof type</option>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Choose what type of proof employees must provide to complete this task.</p>
                    @error('required_proof_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="order_index" class="block text-sm font-medium text-gray-700">Order Position</label>
                    <input type="number" name="order_index" id="order_index" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('order_index', ($list->tasks->count() ?? 0) + 1) }}" placeholder="1">
                    <p class="mt-1 text-sm text-gray-500">The order in which this task should appear in the list.</p>
                    @error('order_index')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Task Options -->
            <div class="space-y-4">
                <div class="flex items-center">
                    <input type="checkbox" name="is_required" id="is_required" value="1" {{ old('is_required', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_required" class="ml-2 block text-sm text-gray-900">
                        Required task (must be completed before submission)
                    </label>
                </div>
                
                <div class="flex items-center">
                    <input type="checkbox" name="requires_signature" id="requires_signature" value="1" {{ old('requires_signature') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
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
                        <option value="{{ $user->id }}" {{ in_array($user->id, old('assigned_users', [])) ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple users. Leave empty to assign to all employees with list access.</p>
                @error('assigned_users')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Proof Type Help -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Proof Type Guide</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li><strong>Photo:</strong> Employee must take and upload a photo</li>
                                <li><strong>Video:</strong> Employee must record and upload a video</li>
                                <li><strong>Text:</strong> Employee must write a note or comment</li>
                                <li><strong>File:</strong> Employee must upload a document or file</li>
                                <li><strong>Any:</strong> Employee can choose any type of proof</li>
                                <li><strong>None:</strong> No proof required, just mark as complete</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.lists.show', $list) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Add Task
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
