@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900 sm:text-4xl">
                        Task Lists
                    </h1>
                    <p class="mt-2 text-lg text-gray-600">
                        Organize and manage your task lists efficiently
                    </p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <a href="{{ route('admin.lists.create') }}" 
                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create New List
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-indigo-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Lists</dt>
                                <dd class="text-2xl font-bold text-gray-900">{{ $lists->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lists Grid/Table Toggle -->
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">All Task Lists</h3>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">{{ $lists->total() }} lists</span>
                    </div>
                </div>
            </div>

            @if($lists->count() > 0)
                <!-- Desktop Table View -->
                <div class="hidden lg:block">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">List Details</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Schedule & Priority</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($lists as $list)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-6">
                                        <div class="flex items-start space-x-4">
                                            <div class="flex-shrink-0">
                                                <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center">
                                                    <span class="text-white font-bold text-lg">{{ substr($list->title, 0, 1) }}</span>
                                                </div>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $list->title }}</h4>
                                                <p class="text-sm text-gray-600 mb-2">{{ Str::limit($list->description, 80) }}</p>
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    {{ $list->category ?? 'Uncategorized' }}
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="space-y-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"></svg>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ ucfirst($list->schedule_type) }}
                                            </span>
                                            <span class="block inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                                @if($list->priority === 'urgent') bg-red-50 text-red-700 border border-red-200
                                                @elseif($list->priority === 'high') bg-orange-50 text-orange-700 border border-orange-200
                                                @elseif($list->priority === 'medium') bg-yellow-50 text-yellow-700 border border-yellow-200
                                                @else bg-green-50 text-green-700 border border-green-200 @endif">
                                                @if($list->priority === 'urgent') ⚡
                                                @elseif($list->priority === 'high') 🔥
                                                @elseif($list->priority === 'medium') ⚠️
                                                @else ✅ @endif
                                                {{ ucfirst($list->priority) }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <div class="space-y-3">
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Tasks</span>
                                                <span class="font-semibold text-gray-900">{{ $list->tasks_count }}</span>
                                            </div>
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600">Submissions</span>
                                                <span class="font-semibold text-gray-900">{{ $list->submissions_count }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                            @if($list->is_active) bg-green-50 text-green-700 border border-green-200
                                            @else bg-gray-50 text-gray-700 border border-gray-200 @endif">
                                            <span class="w-2 h-2 rounded-full mr-2 
                                                @if($list->is_active) bg-green-400
                                                @else bg-gray-400 @endif"></span>
                                            {{ $list->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('admin.lists.show', $list) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('admin.lists.edit', $list) }}" 
                                               class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.lists.destroy', $list) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this list?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                <!-- Mobile Card View -->
                <div class="lg:hidden divide-y divide-gray-200">
                    @foreach($lists as $list)
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">{{ substr($list->title, 0, 1) }}</span>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-lg font-semibold text-gray-900 mb-1">{{ $list->title }}</h4>
                                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($list->description, 80) }}</p>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium 
                                            @if($list->is_active) bg-green-50 text-green-700 border border-green-200
                                            @else bg-gray-50 text-gray-700 border border-gray-200 @endif">
                                            {{ $list->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $list->category ?? 'Uncategorized' }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            {{ ucfirst($list->schedule_type) }}
                                        </span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                                            @if($list->priority === 'urgent') bg-red-50 text-red-700
                                            @elseif($list->priority === 'high') bg-orange-50 text-orange-700
                                            @elseif($list->priority === 'medium') bg-yellow-50 text-yellow-700
                                            @else bg-green-50 text-green-700 @endif">
                                            {{ ucfirst($list->priority) }}
                                        </span>
                                    </div>

                                    <div class="flex items-center justify-between text-sm text-gray-600 mb-4">
                                        <span>{{ $list->tasks_count }} tasks</span>
                                        <span>{{ $list->submissions_count }} submissions</span>
                                    </div>

                                    <div class="flex space-x-3">
                                        <a href="{{ route('admin.lists.show', $list) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">View</a>
                                        <a href="{{ route('admin.lists.edit', $list) }}" class="text-green-600 hover:text-green-900 text-sm font-medium">Edit</a>
                                        <form method="POST" action="{{ route('admin.lists.destroy', $list) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-6 text-xl font-semibold text-gray-900">No task lists yet</h3>
                    <p class="mt-2 text-gray-600 max-w-md mx-auto">Get started by creating your first task list to organize your workflow.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.lists.create') }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create your first list
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($lists->hasPages())
            <div class="mt-8 flex justify-center">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 px-6 py-3">
                    {{ $lists->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection</svg>