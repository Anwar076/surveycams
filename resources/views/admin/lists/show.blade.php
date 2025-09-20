@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Enhanced Page Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-4xl font-bold leading-tight bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent">
                        {{ $list->title }}
                    </h1>
                    <p class="mt-3 text-lg text-slate-600 font-medium">{{ $list->description }}</p>
                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-semibold 
                            @if($list->priority === 'urgent') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                            @elseif($list->priority === 'high') bg-gradient-to-r from-orange-100 to-yellow-100 text-orange-800 border border-orange-200
                            @elseif($list->priority === 'medium') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                            @else bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 @endif">
                        {{ ucfirst($list->priority) }} Priority
                    </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                        {{ ucfirst($list->schedule_type) }}
                    </span>
                    @if($list->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-semibold bg-gradient-to-r from-slate-100 to-gray-100 text-slate-800 border border-slate-200">
                                {{ $list->category }}
                        </span>
                    @endif
                    @if($list->requires_signature)
                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-semibold bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 border border-indigo-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            Signature Required
                        </span>
                    @endif
                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-semibold 
                            @if($list->is_active) bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200
                            @else bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 @endif">
                            <div class="w-2 h-2 rounded-full mr-2 {{ $list->is_active ? 'bg-emerald-500' : 'bg-gray-500' }}"></div>
                        {{ $list->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
                <div class="mt-6 flex space-x-3 md:ml-4 md:mt-0">
                    <a href="{{ route('admin.lists.edit', $list) }}" 
                       class="group inline-flex items-center px-6 py-3 border border-slate-300 text-base font-semibold rounded-2xl shadow-lg text-slate-700 bg-white hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    Edit List
                </a>
                    <a href="{{ route('admin.lists.index') }}" 
                       class="group inline-flex items-center px-6 py-3 border border-slate-300 text-base font-semibold rounded-2xl shadow-lg text-slate-700 bg-white hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Lists
                </a>
            </div>
        </div>
    </div>

        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Total Tasks</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $list->tasks->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-green-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Required Tasks</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $list->tasks->where('is_required', true)->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-indigo-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Assigned Users</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $list->assignments->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-yellow-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Submissions</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $list->submissions->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($list->hasWeeklyStructure())
        <!-- Weekly Schedule Structure Overview -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/30 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-8 py-6 border-b border-slate-200/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">Weekly Schedule Structure</h3>
                            <p class="text-slate-600 font-medium">Day-by-day task organization</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="addTaskToDay()" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-base font-semibold rounded-2xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Task
                        </button>
                        <a href="{{ route('admin.lists.edit', $list) }}" 
                           class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-base font-semibold rounded-2xl hover:from-emerald-600 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Structure
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                <!-- Day Selection Display -->
                <div class="mb-8">
                    <h4 class="text-lg font-bold text-slate-900 mb-4">Weekly Schedule Overview</h4>
                    <p class="text-sm text-slate-600 mb-4">Click on a day to view its tasks. Green days have tasks assigned.</p>
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
                            $selectedDays = $list->getSelectedDays();
                            @endphp
                        @foreach($weekdays as $dayKey => $dayName)
                        @php
                            $dayTasks = $list->getTasksForDay($dayKey);
                            $hasTasks = $dayTasks->count() > 0;
                            $isSelected = in_array($dayKey, $selectedDays);
                        @endphp
                        <div class="group relative">
                            <button onclick="scrollToDaySection('{{ $dayKey }}')" 
                                    class="w-full flex flex-col items-center justify-center p-4 border-2 rounded-2xl transition-all duration-200 hover:scale-105 hover:shadow-lg cursor-pointer
                                    @if($hasTasks) 
                                        border-green-500 bg-green-50 hover:bg-green-100 
                                    @elseif($isSelected) 
                                        border-emerald-500 bg-emerald-50 hover:bg-emerald-100 
                                    @else 
                                        border-slate-200 bg-slate-50 hover:bg-slate-100 
                                    @endif">
                                <div class="w-8 h-8 bg-gradient-to-br 
                                    @if($hasTasks) 
                                        from-green-400 to-green-500 
                                    @elseif($isSelected) 
                                        from-emerald-400 to-emerald-500 
                                    @else 
                                        from-slate-400 to-slate-500 
                                    @endif rounded-xl flex items-center justify-center mb-2 relative">
                                    <span class="text-white font-bold text-xs">{{ substr($dayName, 0, 1) }}</span>
                                    @if($hasTasks)
                                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full flex items-center justify-center">
                                            <span class="text-white text-xs font-bold">{{ $dayTasks->count() }}</span>
                                        </div>
                                    @endif
                                </div>
                                <span class="text-sm font-semibold 
                                    @if($hasTasks) 
                                        text-green-700 
                                    @elseif($isSelected) 
                                        text-emerald-700 
                                    @else 
                                        text-slate-500 
                                    @endif">{{ substr($dayName, 0, 3) }}</span>
                                @if($hasTasks)
                                    <span class="text-xs text-green-600 mt-1">{{ $dayTasks->count() }} task{{ $dayTasks->count() > 1 ? 's' : '' }}</span>
                                @endif
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Day Sections Display -->
                <div class="space-y-6">
                    @foreach($weekdays as $dayKey => $dayName)
                        @php
                            $dayTasks = $list->getTasksForDay($dayKey);
                            $hasTasks = $dayTasks->count() > 0;
                            $isSelected = in_array($dayKey, $selectedDays);
                        @endphp
                        @if($isSelected || $hasTasks)
                        <div id="day-section-{{ $dayKey }}" class="bg-white/95 backdrop-blur-sm shadow-xl rounded-3xl border border-white/40 overflow-hidden">
                            <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-6 py-4 border-b border-slate-200/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                            <span class="text-white font-bold text-sm">{{ substr($dayName, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-900">{{ $dayName }} Tasks</h4>
                                            <p class="text-sm text-slate-600">Tasks scheduled for {{ $dayName }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                            {{ $list->getTasksForDay($dayKey)->count() }} tasks
                                        </span>
                                        <a href="{{ route('admin.lists.tasks.create', ['list' => $list->id, 'weekday' => $dayKey]) }}" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                            Add Task
                        </a>
                    </div>
                </div>
            </div>
            <div class="p-6">
                    @php
                                    $dayTasks = $list->getTasksForDay($dayKey);
                    @endphp
                                @if($dayTasks->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($dayTasks as $task)
                                            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-lg rounded-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/40">
                                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                                <div class="relative p-6">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1">
                                                            <div class="flex items-center space-x-3 mb-3">
                                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                                                    <span class="text-white font-bold text-sm">{{ $task->order ?? $task->order_index }}</span>
                                                </div>
                                                                <div>
                                                                    <h5 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-200">{{ $task->title }}</h5>
                                                @if($task->description)
                                                                        <p class="text-sm text-slate-600 mt-1">{{ $task->description }}</p>
                                                @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="flex flex-wrap items-center gap-2">
                                                    @if($task->is_required)
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200">
                                                            Required
                                                        </span>
                                                    @endif
                                                    @if($task->requires_signature)
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800 border border-purple-200">
                                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                                        </svg>
                                                            Signature
                                                        </span>
                                                    @endif
                                                    @if($task->required_proof_type !== 'none')
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                                            {{ ucfirst($task->required_proof_type) }}
                                                        </span>
                                                    @endif
                                                </div>
                                                            
                                                            @if($task->instructions)
                                                                <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                                                                    <h6 class="text-sm font-semibold text-slate-700 mb-1">Instructions:</h6>
                                                                    <p class="text-sm text-slate-600">{{ $task->instructions }}</p>
                                                                </div>
                                                            @endif
                                            </div>
                                                        <div class="flex space-x-2 ml-4">
                                                            <button onclick="editTask({{ $task->id }})" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                </svg>
                                                                Edit
                                                            </button>
                                                            <button onclick="deleteTask({{ $task->id }})" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white text-sm font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                </svg>
                                                                Delete
                                                            </button>
                                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                                    <div class="text-center py-8">
                                        <div class="w-16 h-16 bg-gradient-to-br from-slate-100 to-slate-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                            </svg>
                                        </div>
                                        <h5 class="text-lg font-bold text-slate-900 mb-2">No tasks for {{ $dayName }}</h5>
                                        <p class="text-slate-600 mb-4">Add tasks for this day to get started</p>
                                        <a href="{{ route('admin.lists.tasks.create', ['list' => $list->id, 'weekday' => $dayKey]) }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                            Add First Task
                                        </a>
                                    </div>
                                @endif
                            </div>
                            </div>
                        @endif
                    @endforeach
                    </div>
            </div>
        </div>
        @endif

        <!-- Tasks Overview -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/30 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-50 to-blue-50 px-8 py-6 border-b border-slate-200/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">General Tasks Overview</h3>
                            <p class="text-slate-600 font-medium">{{ $list->tasks->whereNull('weekday')->count() }} general tasks (not day-specific)</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.lists.tasks.create', $list) }}" 
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-base font-semibold rounded-2xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add General Task
                    </a>
                </div>
            </div>
            
            <div class="p-8">
                @php
                    // Only show general tasks (without weekday) in All Tasks Overview
                    $generalTasks = $list->tasks->whereNull('weekday')->sortBy('order_index');
                @endphp
                @if($generalTasks->count() > 0)
                    <div class="space-y-4">
                        @foreach($generalTasks as $task)
                            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-lg rounded-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/40">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-3">
                                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                                                    <span class="text-white font-bold text-sm">{{ $task->order_index }}</span>
                                    </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-200">{{ $task->title }}</h4>
                                    @if($task->description)
                                                        <p class="text-sm text-slate-600 mt-1">{{ $task->description }}</p>
                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="flex flex-wrap items-center gap-2">
                                        @if($task->is_required)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200">
                                                Required
                                            </span>
                                        @endif
                                        @if($task->requires_signature)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800 border border-purple-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                                        </svg>
                                                Signature
                                            </span>
                                        @endif
                                        @if($task->required_proof_type !== 'none')
                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                                {{ ucfirst($task->required_proof_type) }}
                                            </span>
                                        @endif
                                        @if($task->assignments->count() > 0)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200">
                                                {{ $task->assignments->count() }} assigned
                                            </span>
                                        @endif
                                    </div>
                                            
                                            @if($task->instructions)
                                                <div class="mt-3 p-3 bg-slate-50 rounded-xl border border-slate-200">
                                                    <h5 class="text-sm font-semibold text-slate-700 mb-1">Instructions:</h5>
                                                    <p class="text-sm text-slate-600">{{ $task->instructions }}</p>
                                                </div>
                                            @endif
                                </div>
                                        
                                        <div class="flex space-x-2 ml-4">
                                            <a href="{{ route('admin.tasks.edit', $task) }}" 
                                               class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white text-sm font-semibold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                        @csrf
                                        @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white text-sm font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- Enhanced Empty State -->
                    <div class="text-center py-16">
                        <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-indigo-500/10 rounded-3xl"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">No general tasks yet</h3>
                        <p class="text-lg text-slate-600 mb-8">Add general tasks that apply to all days, or use the weekly structure above for day-specific tasks</p>
                        <a href="{{ route('admin.lists.tasks.create', $list) }}" 
                           class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-indigo-500 via-purple-600 to-pink-600 text-white text-lg font-semibold rounded-2xl hover:from-indigo-600 hover:via-purple-700 hover:to-pink-700 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="relative z-10">Add General Task</span>
                                </a>
                            </div>
                @endif
            </div>
        </div>

        <!-- Enhanced Assignment Management -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/30 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-8 py-6 border-b border-slate-200/50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">Team Assignments</h3>
                            <p class="text-slate-600 font-medium">Manage who has access to this task list</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="showAssignModal()" class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white text-base font-semibold rounded-2xl hover:from-purple-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Assign List
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                @if($list->assignments->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($list->assignments as $assignment)
                            <div class="group relative overflow-hidden bg-white/95 backdrop-blur-sm shadow-lg rounded-2xl hover:shadow-xl transition-all duration-300 hover:-translate-y-1 border border-white/40">
                                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-indigo-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="relative p-6">
                                    <!-- Enhanced User Info Section -->
                                    <div class="flex items-center space-x-4 mb-6">
                                        <div class="relative">
                                            @if($assignment->user)
                                                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                    <span class="text-white font-bold text-xl">{{ substr($assignment->user->name, 0, 2) }}</span>
                                                </div>
                                            @elseif($assignment->department)
                                                <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-16 h-16 bg-gradient-to-br from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                    <span class="text-white font-bold text-xl">NA</span>
                                                </div>
                                            @endif
                                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-gradient-to-br from-emerald-400 to-emerald-500 rounded-full flex items-center justify-center shadow-lg">
                                                <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="text-xl font-bold text-slate-900 group-hover:text-purple-600 transition-colors duration-200">
                                                @if($assignment->user)
                                                    {{ $assignment->user->name }}
                                                @elseif($assignment->department)
                                                    <span class="text-emerald-600">{{ $assignment->department }} Department</span>
                                                @else
                                                    <span class="text-gray-500 italic">User not found</span>
                                                @endif
                                            </h4>
                                            <p class="text-sm text-slate-600 font-medium">
                                                @if($assignment->user)
                                                    {{ $assignment->user->department ?? 'No Department' }}
                                                @elseif($assignment->department)
                                                    <span class="text-emerald-600">Department Assignment</span>
                                                @else
                                                    <span class="text-gray-400">No Department</span>
                                                @endif
                                            </p>
                                            <div class="mt-1">
                                                <span class="inline-flex items-center px-2 py-1 rounded-lg text-xs font-semibold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200">
                                                    <div class="w-2 h-2 bg-emerald-500 rounded-full mr-1"></div>
                                                    Active Assignment
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Enhanced Date Information -->
                                    <div class="bg-gradient-to-r from-slate-50 to-blue-50 rounded-2xl p-4 mb-4 border border-slate-200/50">
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                    <span class="text-sm font-semibold text-slate-600">Assigned</span>
                                                </div>
                                                <span class="font-bold text-slate-900">{{ $assignment->assigned_date->format('M j, Y') }}</span>
                                            </div>
                                            @if($assignment->due_date)
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span class="text-sm font-semibold text-slate-600">Due Date</span>
                </div>
                                                    <span class="font-bold text-slate-900">{{ $assignment->due_date->format('M j, Y') }}</span>
                            </div>
                        @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Enhanced Action Section -->
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-slate-600">Assignment Status</span>
                                        </div>
                                        <button onclick="removeAssignment({{ $assignment->id }})" 
                                                class="group/btn inline-flex items-center px-3 py-2 bg-gradient-to-r from-red-500 to-pink-600 text-white text-sm font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-md hover:shadow-lg hover:scale-105">
                                            <svg class="w-4 h-4 mr-1 group-hover/btn:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                            <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div class="absolute inset-0 bg-gradient-to-br from-purple-500/10 to-indigo-500/10 rounded-3xl"></div>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">No team assignments yet</h3>
                        <p class="text-lg text-slate-600 mb-8">Assign this list to team members or departments to get started</p>
                        <button onclick="showAssignModal()" class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-500 via-indigo-600 to-blue-600 text-white text-lg font-semibold rounded-2xl hover:from-purple-600 hover:via-indigo-700 hover:to-blue-700 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="relative z-10">Assign to Team</span>
                        </button>
                            </div>
                        @endif
            </div>
        </div>
    </div>
</div>
@endsection

<script>
// Day Navigation Function
function scrollToDaySection(dayKey) {
    const daySection = document.getElementById(`day-section-${dayKey}`);
    if (daySection) {
        // Add a highlight effect
        daySection.style.border = '3px solid #10b981';
        daySection.style.boxShadow = '0 0 20px rgba(16, 185, 129, 0.3)';
        
        // Scroll to the section
        daySection.scrollIntoView({ 
            behavior: 'smooth', 
            block: 'start',
            inline: 'nearest'
        });
        
        // Remove highlight after 3 seconds
        setTimeout(() => {
            daySection.style.border = '';
            daySection.style.boxShadow = '';
        }, 3000);
    } else {
        // Check if the day has tasks but no section (shouldn't happen with current logic)
        const dayButton = document.querySelector(`button[onclick="scrollToDaySection('${dayKey}')"]`);
        const hasTasks = dayButton && dayButton.querySelector('.bg-red-500');
        
        if (hasTasks) {
            // Day has tasks but no section - this is a bug
            alert(`Day ${dayKey} has tasks but no section is displayed. Please refresh the page.`);
        } else {
            // Day is not selected in weekly structure
            alert(`Day ${dayKey} is not selected in the weekly structure. Please edit the list to enable this day.`);
        }
    }
}

// Task Management Functions
function editTask(taskId) {
    // Redirect to edit page with proper parameters
    window.location.href = `/admin/tasks/${taskId}/edit`;
}

function deleteTask(taskId) {
    if (confirm('Are you sure you want to delete this task?')) {
        // Show loading state
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Deleting...';
        button.disabled = true;
        
        fetch(`/admin/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error deleting task');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting task');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}


// Compact Assignment Modal
function showAssignModal() {
    const modalHtml = `
        <div id="assignModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full border border-slate-200">
                <!-- Compact Header -->
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white">Assign List</h3>
                        </div>
                        <button onclick="closeAssignModal()" class="text-white/80 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Compact Form -->
                <form id="assignForm" class="p-6 space-y-4">
                    <!-- Assignment Type -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Assignment Type</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="relative cursor-pointer">
                                <input type="radio" name="assignment_type" value="user" checked onchange="toggleAssignmentType()" class="sr-only">
                                <div class="p-3 rounded-xl border-2 border-slate-200 hover:border-purple-300 transition-colors bg-white text-center">
                                    <div class="text-sm font-medium text-slate-700">Individual User</div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer">
                                <input type="radio" name="assignment_type" value="department" onchange="toggleAssignmentType()" class="sr-only">
                                <div class="p-3 rounded-xl border-2 border-slate-200 hover:border-purple-300 transition-colors bg-white text-center">
                                    <div class="text-sm font-medium text-slate-700">Department</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- User Selection -->
                    <div id="userSelection">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Select Team Members</label>
                        <div class="max-h-40 overflow-y-auto border border-slate-300 rounded-xl p-2 bg-white">
                            <div id="userCheckboxes" class="space-y-2">
                                <!-- Users will be loaded here as checkboxes -->
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-slate-500">
                            <span id="selectedCount">0</span> team members selected
                        </div>
                    </div>
                    
                    <!-- Department Selection -->
                    <div id="departmentSelection" style="display: none;">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Department</label>
                        <div class="space-y-3">
                            <div class="grid grid-cols-2 gap-2">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="department_type" value="existing" checked onchange="toggleDepartmentInput()" class="sr-only">
                                    <div class="p-2 rounded-lg border border-slate-200 hover:border-emerald-300 transition-colors bg-white text-center">
                                        <div class="text-xs font-medium text-slate-700">Existing</div>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="department_type" value="custom" onchange="toggleDepartmentInput()" class="sr-only">
                                    <div class="p-2 rounded-lg border border-slate-200 hover:border-emerald-300 transition-colors bg-white text-center">
                                        <div class="text-xs font-medium text-slate-700">Custom</div>
                                    </div>
                                </label>
                            </div>
                            
                            <div id="existingDepartment">
                                <select name="department" class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">Choose department...</option>
                                    <option value="IT">IT Department</option>
                                    <option value="HR">HR Department</option>
                                    <option value="Finance">Finance Department</option>
                                    <option value="Operations">Operations Department</option>
                                    <option value="Marketing">Marketing Department</option>
                                    <option value="Sales">Sales Department</option>
                                    <option value="Customer Service">Customer Service Department</option>
                                    <option value="Legal">Legal Department</option>
                                    <option value="Quality Assurance">Quality Assurance Department</option>
                                    <option value="Research & Development">Research & Development Department</option>
                                </select>
                            </div>
                            
                            <div id="customDepartment" style="display: none;">
                                <input type="text" name="custom_department" placeholder="Enter department name..." 
                                       class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dates -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Assignment Date</label>
                            <input type="date" name="assigned_date" value="${new Date().toISOString().split('T')[0]}" 
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Due Date</label>
                            <input type="date" name="due_date" 
                                   class="w-full px-3 py-2 border border-slate-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-3 pt-4">
                        <button type="button" onclick="closeAssignModal()" 
                                class="flex-1 px-4 py-2 border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2 bg-gradient-to-r from-purple-500 to-indigo-600 text-white rounded-xl hover:from-purple-600 hover:to-indigo-700 transition-all">
                            Assign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
    
    // Load users
    loadUsersSimple();
    
    // Handle form submission
    document.getElementById('assignForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const data = Object.fromEntries(formData);
        
        // Handle checkbox arrays properly
        const userCheckboxes = document.querySelectorAll('input[name="user_ids[]"]:checked');
        data.user_ids = Array.from(userCheckboxes).map(cb => cb.value);
        
        // Handle department assignment logic
        if (data.assignment_type === 'department') {
            if (data.department_type === 'custom') {
                data.department = data.custom_department;
            }
            delete data.department_type;
            delete data.custom_department;
        }
        
        // Handle user_ids array (already in correct format from checkboxes)
        if (data.assignment_type === 'user') {
            // user_ids[] is already an array from checkboxes, no conversion needed
            if (!data.user_ids || data.user_ids.length === 0) {
                alert('Please select at least one team member');
                return;
            }
        }
        
        // Show loading state
        const submitButton = this.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.textContent = 'Assigning...';
        submitButton.disabled = true;
        
        fetch('/admin/lists/{{ $list->id }}/assign', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            return response.text().then(text => {
                console.log('Response text:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.log('Response is not JSON, treating as success');
                    return { success: true, message: 'Assignment successful' };
                }
            });
        })
        .then(data => {
            console.log('Parsed response data:', data);
            if (data.success || data.message) {
                location.reload();
            } else {
                alert(data.message || 'Error assigning list');
            }
        })
        .catch(error => {
            console.error('Detailed error:', error);
            alert(`Error assigning list: ${error.message}`);
        })
        .finally(() => {
            submitButton.textContent = originalText;
            submitButton.disabled = false;
        });
    });
}

function toggleAssignmentType() {
    const userRadio = document.querySelector('input[name="assignment_type"][value="user"]');
    const departmentRadio = document.querySelector('input[name="assignment_type"][value="department"]');
    const userSelection = document.getElementById('userSelection');
    const departmentSelection = document.getElementById('departmentSelection');
    
    if (userRadio && userRadio.checked) {
        userSelection.style.display = 'block';
        departmentSelection.style.display = 'none';
    } else if (departmentRadio && departmentRadio.checked) {
        userSelection.style.display = 'none';
        departmentSelection.style.display = 'block';
    }
}

function toggleDepartmentInput() {
    const existingRadio = document.querySelector('input[name="department_type"][value="existing"]');
    const customRadio = document.querySelector('input[name="department_type"][value="custom"]');
    const existingDepartment = document.getElementById('existingDepartment');
    const customDepartment = document.getElementById('customDepartment');
    
    if (existingRadio && existingRadio.checked) {
        existingDepartment.style.display = 'block';
        customDepartment.style.display = 'none';
    } else if (customRadio && customRadio.checked) {
        existingDepartment.style.display = 'none';
        customDepartment.style.display = 'block';
    }
}

function loadUsersSimple() {
    const container = document.getElementById('userCheckboxes');
    if (!container) return;
    
    // Show loading state
    container.innerHTML = '<div class="text-center py-4 text-slate-500">Loading team members...</div>';
    
    fetch('/admin/users', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.json();
    })
    .then(data => {
        container.innerHTML = '';
        
        if (data.users && data.users.length > 0) {
            data.users.forEach(user => {
                const checkboxDiv = document.createElement('div');
                checkboxDiv.className = 'flex items-center space-x-3 p-2 hover:bg-slate-50 rounded-lg transition-colors';
                checkboxDiv.innerHTML = `
                    <input type="checkbox" name="user_ids[]" value="${user.id}" id="user_${user.id}" 
                           class="w-4 h-4 text-purple-600 border-slate-300 rounded focus:ring-purple-500" 
                           onchange="updateSelectedCount()">
                    <label for="user_${user.id}" class="flex-1 text-sm font-medium text-slate-700 cursor-pointer">
                        ${user.name}${user.department ? ` <span class="text-slate-500">(${user.department})</span>` : ''}
                    </label>
                `;
                container.appendChild(checkboxDiv);
            });
        } else {
            container.innerHTML = '<div class="text-center py-4 text-slate-500">No team members available</div>';
        }
        
        // Update count
        updateSelectedCount();
    })
    .catch(error => {
        console.error('Error loading users:', error);
        container.innerHTML = '<div class="text-center py-4 text-red-500">Error loading users</div>';
    });
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('input[name="user_ids[]"]:checked');
    const countElement = document.getElementById('selectedCount');
    if (countElement) {
        countElement.textContent = checkboxes.length;
    }
}

function closeAssignModal() {
    const modal = document.getElementById('assignModal');
    if (modal) {
        modal.remove();
    }
}

function removeAssignment(assignmentId) {
    if (confirm('Are you sure you want to remove this assignment?')) {
        // Show loading state
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Removing...';
        button.disabled = true;
        
        fetch(`/admin/assignments/${assignmentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error removing assignment');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing assignment');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}
</script>