@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modern Page Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-4xl font-bold leading-tight bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent">
                        Create Task List
                    </h1>
                    <p class="mt-3 text-lg text-slate-600 font-medium">
                        Create a new task list or checklist for your team
                    </p>
                </div>
                <div class="mt-6 flex md:ml-4 md:mt-0">
                    <a href="{{ route('admin.lists.index') }}" 
                       class="group inline-flex items-center px-6 py-3 border border-slate-300 text-base font-semibold rounded-2xl shadow-lg text-slate-700 bg-white hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cancel
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Form -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/50 overflow-hidden">
            <form method="POST" action="{{ route('admin.lists.store') }}" class="space-y-8 p-8">
                @csrf

                <!-- Basic Information -->
                <div class="space-y-8">
                    <div class="border-b border-slate-200/50 pb-8">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">Basic Information</h3>
                        <div class="grid grid-cols-1 gap-8">
                            <div>
                                <label for="title" class="block text-sm font-bold text-slate-700 mb-3">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" required 
                                       class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium" 
                                       value="{{ old('title') }}" 
                                       placeholder="e.g., Daily Office Cleaning">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-bold text-slate-700 mb-3">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                          class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium" 
                                          placeholder="Describe what this task list is for...">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="border-b border-slate-200/50 pb-8">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">Settings</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div>
                                <label for="category" class="block text-sm font-bold text-slate-700 mb-3">Category</label>
                                <input type="text" name="category" id="category" 
                                       class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium" 
                                       value="{{ old('category') }}" 
                                       placeholder="e.g., Cleaning, Safety, Maintenance">
                                @error('category')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="priority" class="block text-sm font-bold text-slate-700 mb-3">Priority <span class="text-red-500">*</span></label>
                                <select name="priority" id="priority" required 
                                        class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium">
                                    <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                                    <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="schedule_type" class="block text-sm font-bold text-slate-700 mb-3">Schedule Type <span class="text-red-500">*</span></label>
                                <select name="schedule_type" id="schedule_type" required 
                                        class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium" 
                                        onchange="toggleScheduleConfig()">
                                    <option value="once" {{ old('schedule_type', 'once') === 'once' ? 'selected' : '' }}>One-time</option>
                                    <option value="daily" {{ old('schedule_type') === 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ old('schedule_type') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ old('schedule_type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="custom" {{ old('schedule_type') === 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                                @error('schedule_type')
                                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Configuration -->
                    <div id="schedule-config" class="border-b border-slate-200/50 pb-8" style="display: none;">
                        <h3 class="text-2xl font-bold text-slate-900 mb-6">Schedule Configuration</h3>
                
                <!-- Daily Schedule -->
                <div id="daily-config" class="hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold text-blue-900">Daily Schedule</h4>
                                <p class="text-sm text-blue-700">This will automatically create separate lists for all 7 days of the week (Monday through Sunday).</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Schedule -->
                <div id="weekly-config" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Days of Week</label>
                    <p class="text-sm text-gray-600 mb-4">Choose which days of the week this list should be active. Separate lists will be created for each selected day.</p>
                    <div class="grid grid-cols-7 gap-2">
                        @php
                            $weekdays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                            $selectedDays = old('schedule_config.weekdays', []);
                        @endphp
                        @foreach($weekdays as $day)
                        <label class="flex items-center justify-center p-2 border rounded cursor-pointer hover:bg-gray-50">
                            <input type="checkbox" name="schedule_config[weekdays][]" value="{{ $day }}" 
                                   class="hidden weekday-checkbox" 
                                   {{ in_array($day, $selectedDays) ? 'checked' : '' }}>
                            <span class="text-sm font-medium">{{ ucfirst(substr($day, 0, 3)) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Monthly Schedule -->
                <div id="monthly-config" class="hidden">
                    <label for="day_of_month" class="block text-sm font-medium text-gray-700">Day of Month</label>
                    <select name="schedule_config[day_of_month]" id="day_of_month" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        @for($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}" {{ old('schedule_config.day_of_month', 1) == $i ? 'selected' : '' }}>
                                {{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Custom Schedule -->
                <div id="custom-config" class="hidden">
                    <div class="space-y-4">
                        <div>
                            <label for="custom_type" class="block text-sm font-medium text-gray-700">Custom Schedule Type</label>
                            <select name="schedule_config[type]" id="custom_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="toggleCustomType()">
                                <option value="specific_days" {{ old('schedule_config.type', '') === 'specific_days' ? 'selected' : '' }}>Specific Days of Week</option>
                                <option value="interval" {{ old('schedule_config.type', '') === 'interval' ? 'selected' : '' }}>Every X Days</option>
                                <option value="date_range" {{ old('schedule_config.type', '') === 'date_range' ? 'selected' : '' }}>Date Range</option>
                            </select>
                        </div>

                        <div id="custom-specific-days" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Days</label>
                            <div class="grid grid-cols-7 gap-2">
                                @php
                                    $customSelectedDays = old('schedule_config.days', []);
                                @endphp
                                @foreach($weekdays as $day)
                                <label class="flex items-center justify-center p-2 border rounded cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="schedule_config[days][]" value="{{ $day }}" 
                                           class="hidden custom-day-checkbox" 
                                           {{ in_array($day, $customSelectedDays) ? 'checked' : '' }}>
                                    <span class="text-sm font-medium">{{ ucfirst(substr($day, 0, 3)) }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div id="custom-interval" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="interval_days" class="block text-sm font-medium text-gray-700">Every X Days</label>
                                    <input type="number" name="schedule_config[interval_days]" id="interval_days" min="1" max="365" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                           value="{{ old('schedule_config.interval_days', 1) }}">
                                </div>
                                <div>
                                    <label for="interval_start" class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <input type="date" name="schedule_config[start_date]" id="interval_start" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                           value="{{ old('schedule_config.start_date', '') }}">
                                </div>
                            </div>
                        </div>

                        <div id="custom-date-range" class="hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="range_start" class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <input type="date" name="schedule_config[start_date]" id="range_start" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                           value="{{ old('schedule_config.start_date', '') }}">
                                </div>
                                <div>
                                    <label for="range_end" class="block text-sm font-medium text-gray-700">End Date</label>
                                    <input type="date" name="schedule_config[end_date]" id="range_end" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                           value="{{ old('schedule_config.end_date', '') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Options -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date (Optional)</label>
                    <input type="datetime-local" name="due_date" id="due_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('due_date') }}">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="parent_list_id" class="block text-sm font-medium text-gray-700">Parent List (Optional)</label>
                    <select name="parent_list_id" id="parent_list_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">None - This is a main list</option>
                        @foreach($parentLists as $parentList)
                            <option value="{{ $parentList->id }}" {{ old('parent_list_id') == $parentList->id ? 'selected' : '' }}>
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
                    <input type="checkbox" name="requires_signature" id="requires_signature" value="1" {{ old('requires_signature') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="requires_signature" class="ml-2 block text-sm text-gray-900">
                        Require digital signature upon completion
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_template" id="is_template" value="1" {{ old('is_template') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_template" class="ml-2 block text-sm text-gray-900">
                        Save as template (can be reused for creating similar lists)
                    </label>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (employees can see and complete this list)
                    </label>
                </div>
            </div>

            </div>

                    <!-- Submit Section -->
                    <div class="flex justify-end space-x-4 pt-8">
                        <a href="{{ route('admin.lists.index') }}" 
                           class="group inline-flex items-center px-8 py-4 border-2 border-slate-300 text-base font-semibold rounded-2xl shadow-lg text-slate-700 bg-white hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="group relative overflow-hidden inline-flex items-center px-8 py-4 border border-transparent text-base font-semibold rounded-2xl shadow-xl text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="relative z-10">Create Task List</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Enhanced Next Steps Info -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-3xl p-8 shadow-lg">
            <div class="flex">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-6">
                    <h3 class="text-xl font-bold text-blue-900 mb-4">What's Next?</h3>
                    <div class="text-blue-800">
                        <p class="text-lg font-medium mb-4">After creating this task list, you'll be able to:</p>
                        <ul class="list-disc list-inside space-y-2 text-base">
                            <li>Add individual tasks to this list</li>
                            <li>Assign this list to specific employees, departments, or roles</li>
                            <li>Set up recurring schedules if needed</li>
                            <li>Monitor completion and review submissions</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleScheduleConfig() {
    const scheduleType = document.getElementById('schedule_type').value;
    const configDiv = document.getElementById('schedule-config');
    const dailyConfig = document.getElementById('daily-config');
    const weeklyConfig = document.getElementById('weekly-config');
    const monthlyConfig = document.getElementById('monthly-config');
    const customConfig = document.getElementById('custom-config');

    // Hide all configs first
    configDiv.style.display = 'none';
    dailyConfig.classList.add('hidden');
    weeklyConfig.classList.add('hidden');
    monthlyConfig.classList.add('hidden');
    customConfig.classList.add('hidden');

    // Show relevant config based on schedule type
    if (scheduleType === 'daily') {
        configDiv.style.display = 'block';
        dailyConfig.classList.remove('hidden');
    } else if (scheduleType === 'weekly') {
        configDiv.style.display = 'block';
        weeklyConfig.classList.remove('hidden');
    } else if (scheduleType === 'monthly') {
        configDiv.style.display = 'block';
        monthlyConfig.classList.remove('hidden');
    } else if (scheduleType === 'custom') {
        configDiv.style.display = 'block';
        customConfig.classList.remove('hidden');
        toggleCustomType(); // Initialize custom type display
    }
}

function toggleCustomType() {
    const customType = document.getElementById('custom_type').value;
    const specificDays = document.getElementById('custom-specific-days');
    const interval = document.getElementById('custom-interval');
    const dateRange = document.getElementById('custom-date-range');

    // Hide all custom configs first
    specificDays.classList.add('hidden');
    interval.classList.add('hidden');
    dateRange.classList.add('hidden');

    // Show relevant config based on custom type
    if (customType === 'specific_days') {
        specificDays.classList.remove('hidden');
    } else if (customType === 'interval') {
        interval.classList.remove('hidden');
    } else if (customType === 'date_range') {
        dateRange.classList.remove('hidden');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleScheduleConfig();
    
    // Handle weekday checkbox styling for schedule config
    const weekdayCheckboxes = document.querySelectorAll('.weekday-checkbox, .custom-day-checkbox');
    weekdayCheckboxes.forEach(checkbox => {
        const label = checkbox.parentElement;
        
        function updateStyle() {
            if (checkbox.checked) {
                label.classList.add('bg-indigo-600', 'text-white', 'border-indigo-600');
                label.classList.remove('hover:bg-gray-50');
            } else {
                label.classList.remove('bg-indigo-600', 'text-white', 'border-indigo-600');
                label.classList.add('hover:bg-gray-50');
            }
        }
        
        updateStyle(); // Initial state
        checkbox.addEventListener('change', updateStyle);
    });
});
</script>
@endsection