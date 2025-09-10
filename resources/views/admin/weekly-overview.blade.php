@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Weekly Overview</h1>
                <p class="mt-1 text-sm text-gray-600">Employee task completion summary</p>
            </div>
            <div class="flex items-center space-x-4">
                <form method="GET" class="flex items-center space-x-2">
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" 
                           class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="text-gray-500">to</span>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" 
                           class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $totalSubmissions = collect($overview)->sum('total_submissions');
            $totalCompleted = collect($overview)->sum('completed');
            $totalInProgress = collect($overview)->sum('in_progress');
            $totalRejected = collect($overview)->sum('rejected');
        @endphp
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Submissions</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalSubmissions }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalCompleted }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">In Progress</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalInProgress }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Rejected</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $totalRejected }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Employee Overview -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Employee Performance</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Employee</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">In Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rejected</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Rate</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($overview as $data)
                        @php
                            $completionRate = $data['total_submissions'] > 0 ? round(($data['completed'] / $data['total_submissions']) * 100) : 0;
                        @endphp
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">
                                                {{ substr($data['employee']->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $data['employee']->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $data['employee']->department ?? 'No Department' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $data['total_submissions'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $data['completed'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $data['in_progress'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ $data['rejected'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 mr-2">
                                        <span class="text-sm font-medium text-gray-900">{{ $completionRate }}%</span>
                                    </div>
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $completionRate }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <a href="{{ route('admin.users.show', $data['employee']) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No employee data available for the selected period.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Daily Breakdown Chart -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Daily Task Completion</h3>
        <div class="h-64 flex items-end justify-between space-x-2">
            @php
                $days = [];
                $currentDate = $startDate->copy();
                while ($currentDate <= $endDate) {
                    $daySubmissions = 0;
                    foreach ($overview as $data) {
                        $daySubmissions += $data['submissions']->filter(function($submission) use ($currentDate) {
                            return $submission->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
                        })->count();
                    }
                    $days[] = [
                        'date' => $currentDate->copy(),
                        'count' => $daySubmissions
                    ];
                    $currentDate->addDay();
                }
                $maxCount = collect($days)->max('count') ?: 1;
            @endphp
            
            @foreach($days as $day)
                <div class="flex flex-col items-center space-y-2 flex-1">
                    <div class="w-full bg-indigo-200 rounded-t" 
                         style="height: {{ $maxCount > 0 ? ($day['count'] / $maxCount) * 200 : 0 }}px">
                        <div class="w-full bg-indigo-600 rounded-t h-full flex items-end justify-center pb-2">
                            @if($day['count'] > 0)
                                <span class="text-white text-xs font-medium">{{ $day['count'] }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 text-center">
                        {{ $day['date']->format('M j') }}<br>
                        {{ $day['date']->format('D') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection