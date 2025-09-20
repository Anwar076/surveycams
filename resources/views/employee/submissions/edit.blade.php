@extends('layouts.employee')

@section('content')
<div class="space-y-6">
    <!-- Progress Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $submission->taskList->title }}</h1>
                <p class="mt-1 text-sm text-gray-600">Started {{ $submission->started_at->format('M j, Y g:i A') }}</p>
            </div>
            <div class="text-right">
                @php
                    $completedTasks = $submission->submissionTasks->where('status', 'completed')->count();
                    $totalTasks = $submission->submissionTasks->count();
                    $progressPercent = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                @endphp
                <div class="text-sm text-gray-500">Progress</div>
                <div class="text-lg font-semibold text-gray-900">{{ $completedTasks }}/{{ $totalTasks }} tasks</div>
                <div class="w-32 bg-gray-200 rounded-full h-2 mt-1">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $progressPercent }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks -->
    <div class="space-y-4">
        @foreach($submission->submissionTasks as $index => $submissionTask)
            @php $task = $submissionTask->task; @endphp
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 {{ $submissionTask->status === 'completed' ? 'bg-green-50' : '' }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($submissionTask->status === 'completed')
                                    <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                        <span class="text-sm text-gray-500">{{ $index + 1 }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium {{ $submissionTask->status === 'completed' ? 'text-green-900' : 'text-gray-900' }}">
                                    {{ $task->title }}
                                </h3>
                                @if($task->description)
                                    <p class="text-sm {{ $submissionTask->status === 'completed' ? 'text-green-700' : 'text-gray-600' }}">
                                        {{ $task->description }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if($task->is_required)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Required
                                </span>
                            @endif
                            @if($task->requires_signature)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Signature
                                </span>
                            @endif
                            @if($submissionTask->status === 'completed')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Completed
                                </span>
                            @elseif($submissionTask->status === 'rejected')
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Rejected
                                </span>
                            @elseif($submissionTask->redo_requested)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    Redo Required
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($submissionTask->status === 'rejected' || $submissionTask->redo_requested)
                    <!-- Rejection/Redo Information -->
                    <div class="px-6 py-4 bg-red-50 border-l-4 border-red-400">
                        <div class="text-sm">
                            @if($submissionTask->status === 'rejected')
                                <h4 class="font-medium text-red-900">Task Rejected</h4>
                                @if($submissionTask->rejection_reason)
                                    <p class="mt-1 text-red-800">
                                        <strong>Reason:</strong> {{ $submissionTask->rejection_reason }}
                                    </p>
                                @endif
                                <p class="mt-2 text-red-700">
                                    This task was rejected on {{ $submissionTask->rejected_at->format('M j, Y g:i A') }}. 
                                    Please review the feedback and complete the task again.
                                </p>
                            @elseif($submissionTask->redo_requested)
                                <h4 class="font-medium text-orange-900">Redo Requested</h4>
                                <p class="mt-1 text-orange-800">
                                    Please redo this task. Review the instructions and complete it again.
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($submissionTask->status === 'pending' || $submissionTask->status === 'rejected' || $submissionTask->redo_requested)
                    <!-- Task Completion Form -->
                    <div class="px-6 py-4">
                        @if($task->instructions)
                            <div class="mb-4 p-3 bg-blue-50 rounded-lg">
                                <h4 class="text-sm font-medium text-blue-900">Instructions</h4>
                                <p class="mt-1 text-sm text-blue-700">{{ $task->instructions }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('employee.submissions.tasks.complete', [$submission, $task]) }}" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <!-- Text Proof -->
                            @if(in_array($task->required_proof_type, ['text', 'any']) || $task->required_proof_type === 'none')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Notes/Comments
                                        @if($task->required_proof_type === 'text') <span class="text-red-500">*</span> @endif
                                    </label>
                                    <textarea name="proof_text" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                        placeholder="Add any notes or comments about completing this task..."
                                        {{ $task->required_proof_type === 'text' ? 'required' : '' }}></textarea>
                                </div>
                            @endif

                            <!-- File/Photo/Video Proof -->
                            @if(in_array($task->required_proof_type, ['photo', 'video', 'file', 'any']))
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Upload {{ ucfirst($task->required_proof_type) }}
                                        @if($task->required_proof_type !== 'any') <span class="text-red-500">*</span> @endif
                                    </label>
                                    <div class="mt-1">
                                        <input type="file" name="proof_files[]" multiple 
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                            @if($task->required_proof_type === 'photo') accept="image/*" @endif
                                            @if($task->required_proof_type === 'video') accept="video/*" @endif
                                            {{ in_array($task->required_proof_type, ['photo', 'video', 'file']) ? 'required' : '' }}>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">
                                        @if($task->required_proof_type === 'photo')
                                            Upload photos as proof of completion. Max 5MB per file.
                                        @elseif($task->required_proof_type === 'video')
                                            Upload videos as proof of completion. Max 10MB per file.
                                        @else
                                            Upload files as proof of completion. Max 10MB per file.
                                        @endif
                                    </p>
                                </div>
                            @endif

                            <!-- Digital Signature for Individual Task -->
                            @if($task->requires_signature)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Signature <span class="text-red-500">*</span></label>
                                    <div class="mt-2">
                                        <canvas id="signature-pad-task-{{ $submissionTask->id }}" class="border border-gray-300 rounded-md bg-white" width="350" height="120"></canvas>
                                        <input type="hidden" name="digital_signature" id="signature-input-task-{{ $submissionTask->id }}" required>
                                        <div class="flex space-x-2 mt-2">
                                            <button type="button" class="px-3 py-1 bg-gray-200 rounded text-xs" onclick="clearSignaturePad('task-{{ $submissionTask->id }}')">Clear</button>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Draw your signature above. This will be saved as proof of completion.</p>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
                                <script>
                                    // Initialize signature pad when page loads
                                    document.addEventListener('DOMContentLoaded', function() {
                                        if (!window.signaturePads) window.signaturePads = {};
                                        
                                        var canvas = document.getElementById('signature-pad-task-{{ $submissionTask->id }}');
                                        if (canvas && typeof SignaturePad !== 'undefined') {
                                            var signaturePad = new SignaturePad(canvas, { 
                                                backgroundColor: 'rgba(255,255,255,0)',
                                                penColor: 'rgb(0, 0, 0)',
                                                minWidth: 1,
                                                maxWidth: 3
                                            });
                                            window.signaturePads['task-{{ $submissionTask->id }}'] = signaturePad;
                                            
                                            // Handle form submission
                                            var form = canvas.closest('form');
                                            if (form) {
                                                form.addEventListener('submit', function(e) {
                                                    if (signaturePad.isEmpty()) {
                                                        alert('Please provide a signature.');
                                                        e.preventDefault();
                                                        return false;
                                                    }
                                                    document.getElementById('signature-input-task-{{ $submissionTask->id }}').value = signaturePad.toDataURL();
                                                });
                                            }
                                        } else {
                                            console.error('SignaturePad not loaded or canvas not found');
                                        }
                                    });
                                    
                                    // Clear signature function
                                    window.clearSignaturePad = function(key) {
                                        if (window.signaturePads && window.signaturePads[key]) {
                                            window.signaturePads[key].clear();
                                        }
                                    }
                                </script>
                            @endif

                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    {{ $task->requires_signature ? '✍️ Sign & Complete' : 'Mark as Complete' }}
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Completed Task Display -->
                    <div class="px-6 py-4 bg-gray-50">
                        <div class="text-sm text-gray-600">
                            <strong>Completed:</strong> {{ $submissionTask->completed_at->format('M j, Y g:i A') }}
                        </div>
                        
                        @if($submissionTask->proof_text)
                            <div class="mt-2">
                                <strong class="text-sm text-gray-700">Notes:</strong>
                                <p class="text-sm text-gray-600 mt-1">{{ $submissionTask->proof_text }}</p>
                            </div>
                        @endif

                        @if($submissionTask->proof_files && count($submissionTask->proof_files) > 0)
                            <div class="mt-2">
                                <strong class="text-sm text-gray-700">Uploaded Files:</strong>
                                <div class="mt-1 space-y-1">
                                    @foreach($submissionTask->proof_files as $file)
                                        <div class="text-sm text-indigo-600">
                                            📎 {{ $file['original_name'] }} ({{ number_format($file['size'] / 1024, 1) }} KB)
                                            @if(isset($file['mime_type']) && strpos($file['mime_type'], 'image/') === 0)
                                                <div class="mt-2">
                                                    <img src="{{ url('storage/' . $file['path']) }}" alt="{{ $file['original_name'] }}" class="max-w-xs max-h-40 rounded shadow border" />
                                                </div>
                                            @endif
                                            @if(isset($file['mime_type']) && strpos($file['mime_type'], 'video/') === 0)
                                                <div class="mt-2">
                                                    <video controls class="max-w-xs max-h-40 rounded shadow border">
                                                        <source src="{{ url('storage/' . $file['path']) }}" type="{{ $file['mime_type'] }}">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Final Submission -->
    @php
        $allRequiredCompleted = $submission->submissionTasks
            ->filter(fn($st) => $st->task->is_required)
            ->every(fn($st) => $st->status === 'completed');
    @endphp

    @if($allRequiredCompleted && $submission->status === 'in_progress')
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Submit Checklist</h3>
            <p class="text-sm text-gray-600 mb-4">All required tasks have been completed. You can now submit this checklist for review.</p>
            
            <form method="POST" action="{{ route('employee.submissions.complete', $submission) }}" class="space-y-4">
                @csrf
                
                @if($submission->taskList->requires_signature)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Digital Signature <span class="text-red-500">*</span></label>
                        <canvas id="signature-pad-final" class="border border-gray-300 rounded-md bg-white mt-1" width="350" height="120"></canvas>
                        <input type="hidden" name="employee_signature" id="signature-input-final" required>
                        <div class="mt-2 flex gap-2">
                            <button type="button" class="px-3 py-1 bg-gray-200 rounded text-xs" onclick="clearSignaturePadFinal()">Clear</button>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Draw your signature above. This will be saved as proof of completion.</p>
                    </div>
                    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            var canvasFinal = document.getElementById('signature-pad-final');
                            if (canvasFinal && typeof SignaturePad !== 'undefined') {
                                var signaturePadFinal = new SignaturePad(canvasFinal, { 
                                    backgroundColor: 'rgba(255,255,255,0)',
                                    penColor: 'rgb(0, 0, 0)',
                                    minWidth: 1,
                                    maxWidth: 3
                                });
                                
                                window.clearSignaturePadFinal = function() {
                                    signaturePadFinal.clear();
                                }
                                
                                var form = document.querySelector('form[action="{{ route('employee.submissions.complete', $submission) }}"]');
                                if (form) {
                                    form.addEventListener('submit', function(e) {
                                        if (signaturePadFinal.isEmpty()) {
                                            e.preventDefault();
                                            alert('Please provide a signature.');
                                            return false;
                                        }
                                        document.getElementById('signature-input-final').value = signaturePadFinal.toDataURL();
                                    });
                                }
                            } else {
                                console.error('SignaturePad not loaded or canvas not found');
                            }
                        });
                    </script>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700">Additional Notes (Optional)</label>
                    <textarea name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Any additional comments about this checklist..."></textarea>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('employee.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Save & Continue Later
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        🎉 Submit Checklist
                    </button>
                </div>
            </form>
        </div>
    @elseif(!$allRequiredCompleted)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Complete Required Tasks</h3>
                    <p class="mt-1 text-sm text-yellow-700">Please complete all required tasks before submitting this checklist.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection