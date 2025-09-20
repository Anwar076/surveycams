@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Modern Header -->
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 p-8 mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-indigo-600 bg-clip-text text-transparent">
                            Edit Task
                        </h1>
                        <p class="text-slate-600 font-medium mt-1">
                            Edit "{{ $task->title }}" in "{{ $task->taskList->title }}"
                        </p>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.lists.show', $task->taskList) }}" 
                       class="px-6 py-3 bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 font-semibold rounded-2xl hover:from-slate-200 hover:to-slate-300 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Cancel
                    </a>
                    <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Are you sure you want to delete this task?')" 
                                class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-2xl hover:from-red-600 hover:to-red-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/30 overflow-hidden">
            <form method="POST" action="{{ route('admin.tasks.update', $task) }}" class="space-y-8 p-8">
                @csrf
                @method('PUT')

                <!-- Basic Information Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-3xl p-6 border border-blue-200/50">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        Basic Information
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-bold text-slate-700 mb-3">Task Title <span class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" required 
                                   class="block w-full px-6 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg font-medium bg-white" 
                                   value="{{ old('title', $task->title) }}" 
                                   placeholder="e.g., Empty all trash bins">
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-slate-700 mb-3">Description</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="block w-full px-6 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg font-medium bg-white resize-none" 
                                      placeholder="Provide a clear description of what needs to be done...">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="instructions" class="block text-sm font-bold text-slate-700 mb-3">Detailed Instructions</label>
                            <textarea name="instructions" id="instructions" rows="4" 
                                      class="block w-full px-6 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-lg font-medium bg-white resize-none" 
                                      placeholder="Provide step-by-step instructions on how to complete this task...">{{ old('instructions', $task->instructions) }}</textarea>
                            <p class="mt-2 text-sm text-slate-600 font-medium">These instructions will be shown to employees when they're completing the task.</p>
                            @error('instructions')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($task->taskList->hasWeeklyStructure())
                <!-- Day Selection Section -->
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-3xl p-6 border border-blue-200/50">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        Select Days for This Task
                    </h3>
                    
                    <div class="mb-4">
                        <p class="text-slate-600 font-medium mb-4">Choose which days of the week this task should be available for:</p>
                        <div class="grid grid-cols-7 gap-3">
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
                                $selectedDays = old('weekdays', $task->weekday ? [$task->weekday] : []);
                            @endphp
                            @foreach($weekdays as $dayKey => $dayName)
                            <div class="group relative">
                                <label class="flex flex-col items-center justify-center p-4 border-2 border-slate-200 rounded-2xl cursor-pointer hover:border-blue-300 hover:bg-blue-50 transition-all duration-200 {{ in_array($dayKey, $selectedDays) ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <input type="checkbox" name="weekdays[]" value="{{ $dayKey }}" 
                                           class="hidden day-checkbox" 
                                           {{ in_array($dayKey, $selectedDays) ? 'checked' : '' }}>
                                    <div class="w-8 h-8 bg-gradient-to-br from-slate-400 to-slate-500 rounded-xl flex items-center justify-center mb-2 group-hover:from-blue-400 group-hover:to-blue-500 transition-all duration-200 {{ in_array($dayKey, $selectedDays) ? 'from-blue-400 to-blue-500' : '' }}">
                                        <span class="text-white font-bold text-xs">{{ substr($dayName, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-700 transition-colors duration-200 {{ in_array($dayKey, $selectedDays) ? 'text-blue-700' : '' }}">{{ substr($dayName, 0, 3) }}</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                            <p class="text-sm text-blue-700 font-medium">
                                <span class="font-bold">Optional:</span> 
                                Select specific days for this task, or leave empty to create a general task for the entire list.
                            </p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Task Settings Section -->
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-3xl p-6 border border-emerald-200/50">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        Task Settings
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="required_proof_type" class="block text-sm font-bold text-slate-700 mb-3">Required Proof Type <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="required_proof_type" id="required_proof_type" required 
                                        class="block w-full px-6 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg font-medium bg-white">
                                    <option value="none" {{ old('required_proof_type', $task->required_proof_type) === 'none' ? 'selected' : '' }}>No proof required</option>
                                    <option value="photo" {{ old('required_proof_type', $task->required_proof_type) === 'photo' ? 'selected' : '' }}>Photo required</option>
                                    <option value="video" {{ old('required_proof_type', $task->required_proof_type) === 'video' ? 'selected' : '' }}>Video required</option>
                                    <option value="text" {{ old('required_proof_type', $task->required_proof_type) === 'text' ? 'selected' : '' }}>Text note required</option>
                                    <option value="file" {{ old('required_proof_type', $task->required_proof_type) === 'file' ? 'selected' : '' }}>File upload required</option>
                                    <option value="any" {{ old('required_proof_type', $task->required_proof_type) === 'any' ? 'selected' : '' }}>Any proof type</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-slate-600 font-medium">Choose what type of proof employees must provide to complete this task.</p>
                            @error('required_proof_type')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="order_index" class="block text-sm font-bold text-slate-700 mb-3">Order Position</label>
                            <input type="number" name="order_index" id="order_index" min="1" 
                                   class="block w-full px-6 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 text-lg font-medium bg-white" 
                                   value="{{ old('order_index', $task->order_index) }}" placeholder="1">
                            <p class="mt-2 text-sm text-slate-600 font-medium">The order in which this task should appear in the list.</p>
                            @error('order_index')
                                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Task Options Section -->
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-3xl p-6 border border-amber-200/50">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Task Options
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-white/70 rounded-2xl border border-amber-200/50">
                            <input type="checkbox" name="is_required" id="is_required" value="1" 
                                   {{ old('is_required', $task->is_required) ? 'checked' : '' }} 
                                   class="w-5 h-5 text-amber-600 bg-white border-2 border-amber-300 rounded focus:ring-amber-500 focus:ring-2">
                            <label for="is_required" class="ml-3 text-slate-700 font-semibold">
                                Required task (must be completed before submission)
                            </label>
                        </div>
                        
                        <div class="flex items-center p-4 bg-white/70 rounded-2xl border border-amber-200/50">
                            <input type="checkbox" name="requires_signature" id="requires_signature" value="1" 
                                   {{ old('requires_signature', $task->requires_signature) ? 'checked' : '' }} 
                                   class="w-5 h-5 text-amber-600 bg-white border-2 border-amber-300 rounded focus:ring-amber-500 focus:ring-2">
                            <label for="requires_signature" class="ml-3 text-slate-700 font-semibold">
                                Requires digital signature for completion
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Proof Type Guide Section -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-3xl p-6 border border-purple-200/50">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Proof Type Guide
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="p-4 bg-white/70 rounded-2xl border border-purple-200/50">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-slate-400 to-slate-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700">None</span>
                            </div>
                            <p class="text-sm text-slate-600">No proof required - task completion is sufficient.</p>
                        </div>
                        
                        <div class="p-4 bg-white/70 rounded-2xl border border-purple-200/50">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700">Photo</span>
                            </div>
                            <p class="text-sm text-slate-600">Employee must take a photo as proof of completion.</p>
                        </div>
                        
                        <div class="p-4 bg-white/70 rounded-2xl border border-purple-200/50">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700">Video</span>
                            </div>
                            <p class="text-sm text-slate-600">Employee must record a video as proof of completion.</p>
                        </div>
                        
                        <div class="p-4 bg-white/70 rounded-2xl border border-purple-200/50">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700">Text</span>
                            </div>
                            <p class="text-sm text-slate-600">Employee must write a text note describing completion.</p>
                        </div>
                        
                        <div class="p-4 bg-white/70 rounded-2xl border border-purple-200/50">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-purple-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700">File</span>
                            </div>
                            <p class="text-sm text-slate-600">Employee must upload a file as proof of completion.</p>
                        </div>
                        
                        <div class="p-4 bg-white/70 rounded-2xl border border-purple-200/50">
                            <div class="flex items-center mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <span class="font-bold text-slate-700">Any</span>
                            </div>
                            <p class="text-sm text-slate-600">Employee can choose any proof type to complete the task.</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="bg-gradient-to-r from-slate-100 to-slate-200 rounded-3xl p-6 border border-slate-300/50">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('admin.lists.show', $task->taskList) }}" 
                           class="px-8 py-4 bg-gradient-to-r from-slate-200 to-slate-300 text-slate-700 font-bold rounded-2xl hover:from-slate-300 hover:to-slate-400 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-bold rounded-2xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                            Update Task
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<script>
// Day Selection Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Handle day checkbox styling and functionality
    const dayCheckboxes = document.querySelectorAll('.day-checkbox');
    
    dayCheckboxes.forEach(checkbox => {
        const label = checkbox.parentElement;
        
        function updateStyle() {
            if (checkbox.checked) {
                label.classList.add('border-blue-500', 'bg-blue-50');
                label.classList.remove('hover:border-blue-300', 'hover:bg-blue-50');
                // Update the icon styling
                const icon = label.querySelector('div');
                icon.classList.add('from-blue-400', 'to-blue-500');
                icon.classList.remove('from-slate-400', 'to-slate-500');
                // Update the text styling
                const text = label.querySelector('span:last-child');
                text.classList.add('text-blue-700');
                text.classList.remove('text-slate-700');
            } else {
                label.classList.remove('border-blue-500', 'bg-blue-50');
                label.classList.add('hover:border-blue-300', 'hover:bg-blue-50');
                // Update the icon styling
                const icon = label.querySelector('div');
                icon.classList.remove('from-blue-400', 'to-blue-500');
                icon.classList.add('from-slate-400', 'to-slate-500');
                // Update the text styling
                const text = label.querySelector('span:last-child');
                text.classList.remove('text-blue-700');
                text.classList.add('text-slate-700');
            }
        }
        
        // Initial state
        updateStyle();
        
        // Add click event to label
        label.addEventListener('click', function(e) {
            e.preventDefault();
            checkbox.checked = !checkbox.checked;
            updateStyle();
        });
        
        // Add change event to checkbox
        checkbox.addEventListener('change', updateStyle);
    });
    
    // Form validation for weekly structure (optional - no days selected = general task)
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const weekdaysCheckboxes = document.querySelectorAll('input[name="weekdays[]"]:checked');
            // No validation needed - if no days selected, it becomes a general task
            console.log('Selected days:', weekdaysCheckboxes.length);
        });
    }
});
</script>