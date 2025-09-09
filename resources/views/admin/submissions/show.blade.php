@extends('layouts.admin')

@section('title', 'Submission Details')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Submission Details</h1>
    <!-- Example details, replace with actual data -->
    <div class="bg-white shadow rounded p-6">
        <p><strong>ID:</strong> {{ $submission->id }}</p>
        <p><strong>User:</strong> {{ $submission->user->name ?? '-' }}</p>
        <p><strong>List:</strong> {{ $submission->list->name ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $submission->status }}</p>
        <p><strong>Started At:</strong> {{ $submission->started_at }}</p>
        <p><strong>Completed At:</strong> {{ $submission->completed_at }}</p>
        <p><strong>Notes:</strong> {{ $submission->notes }}</p>
        <!-- Add more fields as needed -->
    </div>
    <a href="{{ route('admin.submissions.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">Back to submissions</a>
</div>
@endsection
