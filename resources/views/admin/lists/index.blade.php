@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Modern Page Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-4xl font-bold leading-tight bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 bg-clip-text text-transparent">
                        Task Lists
                    </h1>
                    <p class="mt-3 text-lg text-slate-600 font-medium">
                        Organize and manage your task lists efficiently
                    </p>
                </div>
                <div class="mt-6 flex md:ml-4 md:mt-0">
                    <a href="{{ route('admin.lists.create') }}" 
                       class="group relative overflow-hidden inline-flex items-center px-8 py-4 border border-transparent text-base font-semibold rounded-2xl shadow-xl text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <span class="relative z-10">Create New List</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Enhanced Statistics Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="group relative overflow-hidden bg-white/90 backdrop-blur-sm shadow-xl rounded-2xl hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-white/30">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                <div class="relative p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-semibold text-slate-600 uppercase tracking-wide">Total Lists</dt>
                                <dd class="text-3xl font-bold text-slate-900 mt-1">{{ $lists->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-indigo-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">Active lists</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/50 overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-slate-200/50 bg-gradient-to-r from-slate-50/80 to-blue-50/80">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">Search & Filter</h3>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            {{ $lists->total() }} lists
                        </span>
                    </div>
                </div>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.lists.index') }}" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Search Input -->
                        <div class="lg:col-span-2">
                            <label for="search" class="block text-sm font-bold text-slate-700 mb-3">Search Lists</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" 
                                       name="search" 
                                       id="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Search by title, description, or category..." 
                                       class="block w-full pl-12 pr-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium bg-white/95 backdrop-blur-sm">
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-bold text-slate-700 mb-3">Category</label>
                            <select name="category" id="category" 
                                    class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium bg-white/95 backdrop-blur-sm">
                                <option value="">All Categories</option>
                                <option value="Cleaning" {{ request('category') === 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                                <option value="Safety" {{ request('category') === 'Safety' ? 'selected' : '' }}>Safety</option>
                                <option value="Maintenance" {{ request('category') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="Quality" {{ request('category') === 'Quality' ? 'selected' : '' }}>Quality</option>
                                <option value="Security" {{ request('category') === 'Security' ? 'selected' : '' }}>Security</option>
                                <option value="Other" {{ request('category') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <!-- Priority Filter -->
                        <div>
                            <label for="priority" class="block text-sm font-bold text-slate-700 mb-3">Priority</label>
                            <select name="priority" id="priority" 
                                    class="block w-full px-4 py-4 border-2 border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 text-lg font-medium bg-white/95 backdrop-blur-sm">
                                <option value="">All Priorities</option>
                                <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
                            </select>
                        </div>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-200/50">
                        <div class="flex items-center space-x-4">
                            <button type="submit" 
                                    class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white text-base font-semibold rounded-2xl hover:from-indigo-600 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl hover:scale-105">
                                <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Search
                            </button>
                            
                            @if(request()->hasAny(['search', 'category', 'priority']))
                                <a href="{{ route('admin.lists.index') }}" 
                                   class="group inline-flex items-center px-6 py-3 border-2 border-slate-300 text-base font-semibold rounded-2xl shadow-lg text-slate-700 bg-white hover:bg-gradient-to-r hover:from-slate-50 hover:to-blue-50 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-xl">
                                    <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Clear Filters
                                </a>
                            @endif
                        </div>

                        <!-- Active Filters Display -->
                        @if(request()->hasAny(['search', 'category', 'priority']))
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-semibold text-slate-600">Active filters:</span>
                                @if(request('search'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                                        Search: "{{ request('search') }}"
                                    </span>
                                @endif
                                @if(request('category'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 border border-emerald-200">
                                        Category: {{ request('category') }}
                                    </span>
                                @endif
                                @if(request('priority'))
                                    <span class="inline-flex items-center px-3 py-1 rounded-xl text-xs font-semibold bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200">
                                        Priority: {{ ucfirst(request('priority')) }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Enhanced Lists Container -->
        <div class="bg-white/90 backdrop-blur-sm shadow-2xl rounded-3xl border border-white/50 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-200/50 bg-gradient-to-r from-slate-50/80 to-blue-50/80">
                <div class="flex items-center justify-between">
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-slate-900 to-slate-700 bg-clip-text text-transparent">All Task Lists</h3>
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            {{ $lists->total() }} lists
                        </span>
                    </div>
                </div>
            </div>

            @if($lists->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden lg:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200/50">
                            <thead class="bg-gradient-to-r from-slate-50/80 to-blue-50/80">
                                <tr>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">List Details</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Schedule & Priority</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Progress</th>
                                    <th class="px-8 py-6 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                                    <th class="px-8 py-6 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white/50 divide-y divide-slate-200/50">
                                @foreach($lists as $list)
                                    <tr class="group hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                                        <td class="px-8 py-8">
                                            <div class="flex items-start space-x-6">
                                                <div class="flex-shrink-0">
                                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                                        <span class="text-white font-bold text-xl">{{ substr($list->title, 0, 1) }}</span>
                                                    </div>
                                                </div>
                                                <div class="min-w-0 flex-1">
                                                    <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors duration-200">{{ $list->title }}</h4>
                                                    <p class="text-sm text-slate-600 mb-3 leading-relaxed">{{ Str::limit($list->description, 100) }}</p>
                                                    <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 border border-slate-200">
                                                        {{ $list->category ?? 'Uncategorized' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-8">
                                            <div class="space-y-3">
                                                <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200 shadow-sm">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ ucfirst($list->schedule_type) }}
                                                </span>
                                                <span class="block inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold shadow-sm
                                                    @if($list->priority === 'urgent') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                                                    @elseif($list->priority === 'high') bg-gradient-to-r from-orange-100 to-amber-100 text-orange-800 border border-orange-200
                                                    @elseif($list->priority === 'medium') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                                                    @else bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 @endif">
                                                    @if($list->priority === 'urgent') ⚡
                                                    @elseif($list->priority === 'high') 🔥
                                                    @elseif($list->priority === 'medium') ⚠️
                                                    @else ✅ @endif
                                                    {{ ucfirst($list->priority) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-8">
                                            <div class="space-y-4">
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-slate-600 font-medium">Tasks</span>
                                                    <span class="font-bold text-slate-900 text-lg">{{ $list->tasks_count }}</span>
                                                </div>
                                                <div class="flex items-center justify-between text-sm">
                                                    <span class="text-slate-600 font-medium">Submissions</span>
                                                    <span class="font-bold text-slate-900 text-lg">{{ $list->submissions_count }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-8">
                                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold shadow-sm
                                                @if($list->is_active) bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                                @else bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 border border-slate-200 @endif">
                                                <span class="w-2 h-2 rounded-full mr-2
                                                    @if($list->is_active) bg-green-400
                                                    @else bg-slate-400 @endif"></span>
                                                {{ $list->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-8 text-right">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('admin.lists.show', $list) }}" 
                                                   class="group/action inline-flex items-center px-4 py-2 border border-slate-300 shadow-sm text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 hover:border-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 hover:shadow-lg">
                                                    <svg class="w-4 h-4 mr-2 group-hover/action:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    View
                                                </a>
                                                <a href="{{ route('admin.lists.edit', $list) }}" 
                                                   class="group/action inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                                    <svg class="w-4 h-4 mr-2 group-hover/action:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.lists.destroy', $list) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this list?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="group/action inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                                                        <svg class="w-4 h-4 mr-2 group-hover/action:scale-110 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-slate-200/50">
                    @foreach($lists as $list)
                        <div class="p-8 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-indigo-50/50 transition-all duration-300">
                            <div class="flex items-start space-x-6">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-xl">{{ substr($list->title, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-900 mb-2">{{ $list->title }}</h4>
                                            <p class="text-sm text-slate-600 mb-4 leading-relaxed">{{ Str::limit($list->description, 100) }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-sm font-semibold 
                                            @if($list->is_active) bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                            @else bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 border border-slate-200 @endif">
                                            {{ $list->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-slate-100 to-slate-200 text-slate-700 border border-slate-200">
                                            {{ $list->category ?? 'Uncategorized' }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-800 border border-blue-200">
                                            {{ ucfirst($list->schedule_type) }}
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-semibold 
                                            @if($list->priority === 'urgent') bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200
                                            @elseif($list->priority === 'high') bg-gradient-to-r from-orange-100 to-amber-100 text-orange-800 border border-orange-200
                                            @elseif($list->priority === 'medium') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                                            @else bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 @endif">
                                            {{ ucfirst($list->priority) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-slate-600 mb-6">
                                        <span class="font-semibold">{{ $list->tasks_count }} tasks</span>
                                        <span class="font-semibold">{{ $list->submissions_count }} submissions</span>
                                    </div>

                                    <div class="flex space-x-4">
                                        <a href="{{ route('admin.lists.show', $list) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-semibold">View</a>
                                        <a href="{{ route('admin.lists.edit', $list) }}" class="text-green-600 hover:text-green-900 text-sm font-semibold">Edit</a>
                                        <form method="POST" action="{{ route('admin.lists.destroy', $list) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-semibold">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="text-center py-20">
                    <div class="relative w-32 h-32 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-lg">
                        <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/10 to-purple-500/10 rounded-3xl"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-3">No task lists yet</h3>
                    <p class="text-slate-600 max-w-md mx-auto text-lg leading-relaxed mb-8">Get started by creating your first task list to organize your workflow and boost productivity.</p>
                    <div class="mt-8">
                        <a href="{{ route('admin.lists.create') }}" 
                           class="group relative overflow-hidden inline-flex items-center px-8 py-4 border border-transparent text-base font-semibold rounded-2xl shadow-xl text-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:from-indigo-700 hover:via-purple-700 hover:to-pink-700 transition-all duration-300 hover:shadow-2xl hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="relative z-10">Create your first list</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Enhanced Pagination -->
        @if($lists->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 px-8 py-4">
                    {{ $lists->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection</svg>