@extends('layouts.employee')

@section('content')
<div class="space-y-6">
    <!-- Task List Header -->
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
                    <span class="text-sm text-gray-500">{{ $list->tasks->count() }} tasks</span>
                    @if($list->requires_signature)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Signature Required
                        </span>
                    @endif
                </div>
            </div>
            <div>
                @if($existingSubmission)
                    <a href="{{ route('employee.submissions.edit', $existingSubmission) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Continue Working
                    </a>
                @else
                    <form method="POST" action="{{ route('employee.submissions.start', $list) }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Start Checklist
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Task Preview -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Tasks Preview</h3>
        </div>
        <div class="divide-y divide-gray-200">
            @foreach($list->tasks as $task)
                <div class="px-6 py-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="w-4 h-4 border-2 border-gray-300 rounded"></div>
                        </div>
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $task->title }}</h4>
                                    @if($task->description)
                                        <p class="mt-1 text-sm text-gray-600">{{ $task->description }}</p>
                                    @endif
                                    @if($task->instructions)
                                        <div class="mt-2 text-sm text-gray-500">
                                            <strong>Instructions:</strong> {{ $task->instructions }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($task->is_required)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Required
                                        </span>
                                    @endif
                                    @if($task->required_proof_type !== 'none')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst($task->required_proof_type) }} Required
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Instructions -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Instructions</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li>Click "Start Checklist" to begin working on this task list</li>
                        <li>Complete each task in order, providing required proof when needed</li>
                        <li>You can save your progress and continue later</li>
                        @if($list->requires_signature)
                            <li>A digital signature will be required before final submission</li>
                        @endif
                        <li>Once all required tasks are complete, submit for manager review</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Dashboard -->
    <div class="flex justify-center">
        <a href="{{ route('employee.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            ← Back to Dashboard
        </a>
    </div>
</div>
@endsection