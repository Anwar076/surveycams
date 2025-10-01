@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Task List</h1>
                <p class="mt-1 text-sm text-gray-600">Create a new task list or checklist</p>
            </div>
            <a href="{{ route('admin.lists.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Cancel
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('admin.lists.store') }}" class="space-y-6 p-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('title') }}" placeholder="e.g., Daily Office Cleaning">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Describe what this task list is for...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Settings -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <input type="text" name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('category') }}" placeholder="e.g., Cleaning, Safety, Maintenance">
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority <span class="text-red-500">*</span></label>
                    <select name="priority" id="priority" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="schedule_type" class="block text-sm font-medium text-gray-700">Schedule Type <span class="text-red-500">*</span></label>
                    <select name="schedule_type" id="schedule_type" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="toggleScheduleConfig()">
                        <option value="once" {{ old('schedule_type', 'once') === 'once' ? 'selected' : '' }}>One-time</option>
                        <option value="daily" {{ old('schedule_type') === 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ old('schedule_type') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ old('schedule_type') === 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="custom" {{ old('schedule_type') === 'custom' ? 'selected' : '' }}>Custom</option>
                    </select>
                    @error('schedule_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Schedule Configuration -->
            <div id="schedule-config" class="space-y-4" style="display: none;">
                <h3 class="text-lg font-medium text-gray-900">Schedule Configuration</h3>
                
                <!-- Weekly Schedule -->
                <div id="weekly-config" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Days of Week</label>
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
                
                <div class="flex items-center" id="daily_sublists_option">
                    <input type="checkbox" name="create_daily_sublists" id="create_daily_sublists" value="1" {{ old('create_daily_sublists') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="create_daily_sublists" class="ml-2 block text-sm text-gray-900">
                        Create daily sub-lists for each day of the week
                    </label>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.lists.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Create Task List
                </button>
            </div>
        </form>
    </div>

    <!-- Next Steps Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">What's Next?</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <p>After creating this task list, you'll be able to:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
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

<script>
function toggleScheduleConfig() {
    const scheduleType = document.getElementById('schedule_type').value;
    const configDiv = document.getElementById('schedule-config');
    const weeklyConfig = document.getElementById('weekly-config');
    const monthlyConfig = document.getElementById('monthly-config');
    const customConfig = document.getElementById('custom-config');

    // Hide all configs first
    configDiv.style.display = 'none';
    weeklyConfig.classList.add('hidden');
    monthlyConfig.classList.add('hidden');
    customConfig.classList.add('hidden');

    // Show relevant config based on schedule type
    if (scheduleType === 'weekly') {
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

    // Hide all custom configs
    specificDays.classList.add('hidden');
    interval.classList.add('hidden');
    dateRange.classList.add('hidden');

    // Show relevant custom config
    if (customType === 'specific_days') {
        specificDays.classList.remove('hidden');
    } else if (customType === 'interval') {
        interval.classList.remove('hidden');
    } else if (customType === 'date_range') {
        dateRange.classList.remove('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const parentListSelect = document.getElementById('parent_list_id');
    const scheduleTypeSelect = document.getElementById('schedule_type');
    const dailySublistsOption = document.getElementById('daily_sublists_option');
    
    function toggleDailySublistsOption() {
        if (parentListSelect.value) {
            // This is a sub-list, hide the option
            dailySublistsOption.style.display = 'none';
        } else if (scheduleTypeSelect.value === 'daily') {
            // This is a main list with daily schedule, show the option
            dailySublistsOption.style.display = 'flex';
        } else {
            // This is a main list but not daily schedule, hide the option
            dailySublistsOption.style.display = 'none';
        }
    }
    
    parentListSelect.addEventListener('change', toggleDailySublistsOption);
    scheduleTypeSelect.addEventListener('change', function() {
        toggleDailySublistsOption();
        toggleScheduleConfig();
    });
    
    // Initialize schedule config display
    toggleScheduleConfig();
    toggleDailySublistsOption(); // Initial check
    
    // Handle weekday checkbox styling
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