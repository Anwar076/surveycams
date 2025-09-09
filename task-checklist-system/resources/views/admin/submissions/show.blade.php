@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Submission Review</h1>
                <p class="mt-2 text-gray-600">{{ $submission->taskList->title }} by {{ $submission->user->name }}</p>
                <div class="mt-4 flex items-center space-x-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($submission->status === 'completed') bg-yellow-100 text-yellow-800
                        @elseif($submission->status === 'reviewed') bg-green-100 text-green-800
                        @elseif($submission->status === 'rejected') bg-red-100 text-red-800
                        @else bg-blue-100 text-blue-800 @endif">
                        {{ ucfirst($submission->status) }}
                    </span>
                    @if($submission->completed_at)
                        <span class="text-sm text-gray-500">
                            Completed {{ $submission->completed_at->format('M j, Y g:i A') }}
                        </span>
                    @endif
                    @if($submission->started_at)
                        <span class="text-sm text-gray-500">
                            Started {{ $submission->started_at->format('M j, Y g:i A') }}
                        </span>
                    @endif
                </div>
            </div>
            <a href="{{ route('admin.submissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                ← Back to Submissions
            </a>
        </div>
    </div>

    <!-- Employee Info -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Employee Information</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <dt class="text-sm font-medium text-gray-500">Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->user->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Department</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->user->department }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Email</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->user->email }}</dd>
            </div>
        </div>
    </div>

    @if($submission->status === 'completed')
        <!-- Review Form -->
        <form method="POST" action="{{ route('admin.submissions.review', $submission) }}" class="space-y-6">
            @csrf
    @endif

    <!-- Tasks Review -->
    <div class="space-y-4">
        @foreach($submission->submissionTasks as $index => $submissionTask)
            @php $task = $submissionTask->task; @endphp
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 {{ $submissionTask->status === 'completed' || $submissionTask->status === 'approved' ? 'bg-green-50' : ($submissionTask->status === 'rejected' ? 'bg-red-50' : '') }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($submissionTask->status === 'completed' || $submissionTask->status === 'approved')
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @elseif($submissionTask->status === 'rejected')
                                    <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-sm text-gray-500">{{ $index + 1 }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-gray-900">{{ $task->title }}</h3>
                                @if($task->description)
                                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($task->is_required)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Required
                                </span>
                            @endif
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                @if($submissionTask->status === 'completed') bg-yellow-100 text-yellow-800
                                @elseif($submissionTask->status === 'approved') bg-green-100 text-green-800
                                @elseif($submissionTask->status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($submissionTask->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4">
                    @if($submissionTask->status !== 'pending')
                        <!-- Completed Task Display -->
                        <div class="space-y-4">
                            @if($submissionTask->completed_at)
                                <div class="text-sm text-gray-600">
                                    <strong>Completed:</strong> {{ $submissionTask->completed_at->format('M j, Y g:i A') }}
                                </div>
                            @endif
                            
                            @if($submissionTask->proof_text)
                                <div>
                                    <strong class="text-sm text-gray-700">Employee Notes:</strong>
                                    <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-3 rounded">{{ $submissionTask->proof_text }}</p>
                                </div>
                            @endif

                            @if($submissionTask->proof_files && count($submissionTask->proof_files) > 0)
                                <div>
                                    <strong class="text-sm text-gray-700">Uploaded Files:</strong>
                                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($submissionTask->proof_files as $file)
                                            <div class="border border-gray-200 rounded-lg p-3">
                                                <div class="flex items-center space-x-2">
                                                    @if(str_starts_with($file['mime_type'], 'image/'))
                                                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @elseif(str_starts_with($file['mime_type'], 'video/'))
                                                        <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14.553 7.106A1 1 0 0014 8v4a1 1 0 00.553.894l2 1A1 1 0 0018 13V7a1 1 0 00-1.447-.894l-2 1z"></path>
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    @endif
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $file['original_name'] }}</p>
                                                        <p class="text-xs text-gray-500">{{ number_format($file['size'] / 1024, 1) }} KB</p>
                                                    </div>
                                                </div>
                                                @if(str_starts_with($file['mime_type'], 'image/'))
                                                    <div class="mt-2">
                                                        <img src="{{ Storage::url($file['path']) }}" alt="Proof image" class="w-full h-32 object-cover rounded">
                                                    </div>
                                                @endif
                                                <div class="mt-2">
                                                    <a href="{{ Storage::url($file['path']) }}" target="_blank" class="text-xs text-indigo-600 hover:text-indigo-500">
                                                        View File →
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($submission->status === 'completed')
                                <!-- Review Section -->
                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Review This Task</h4>
                                    <div class="space-y-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Decision</label>
                                            <div class="mt-1 space-x-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="task_reviews[{{ $task->id }}][status]" value="approved" class="form-radio text-green-600">
                                                    <span class="ml-2 text-sm text-gray-700">✅ Approve</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="task_reviews[{{ $task->id }}][status]" value="rejected" class="form-radio text-red-600">
                                                    <span class="ml-2 text-sm text-gray-700">❌ Reject</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Comment (Optional)</label>
                                            <textarea name="task_reviews[{{ $task->id }}][comment]" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Add feedback for the employee..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            @elseif($submissionTask->manager_comment)
                                <!-- Previous Review -->
                                <div class="border-t border-gray-200 pt-4">
                                    <h4 class="text-sm font-medium text-gray-900">Manager Feedback</h4>
                                    <p class="mt-1 text-sm text-gray-600 bg-gray-50 p-3 rounded">{{ $submissionTask->manager_comment }}</p>
                                    @if($submissionTask->reviewed_at)
                                        <p class="mt-2 text-xs text-gray-500">
                                            Reviewed by {{ $submissionTask->reviewer->name }} on {{ $submissionTask->reviewed_at->format('M j, Y g:i A') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @else
                        <!-- Pending Task -->
                        <div class="text-center py-8 text-gray-500">
                            <p class="text-sm">This task has not been completed yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    @if($submission->status === 'completed')
        <!-- Submit Review -->
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Complete Review</h3>
                    <p class="mt-1 text-sm text-gray-600">Review all tasks above, then submit your feedback.</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.submissions.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Submit Review
                    </button>
                </div>
            </div>
        </div>
        </form>
    @endif

    <!-- Submission Details -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Submission Details</h3>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Started At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $submission->started_at->format('M j, Y g:i A') }}</dd>
            </div>
            @if($submission->completed_at)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Completed At</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $submission->completed_at->format('M j, Y g:i A') }}</dd>
                </div>
            @endif
            @if($submission->employee_signature)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Employee Signature</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $submission->employee_signature }}</dd>
                </div>
            @endif
            @if($submission->notes)
                <div class="md:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Employee Notes</dt>
                    <dd class="mt-1 text-sm text-gray-900 bg-gray-50 p-3 rounded">{{ $submission->notes }}</dd>
                </div>
            @endif
        </dl>
    </div>
</div>
@endsection