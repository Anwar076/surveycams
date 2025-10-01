<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="hidden md:flex md:w-64 md:flex-col">
            <div class="flex flex-col flex-grow pt-5 overflow-y-auto bg-white border-r border-gray-200">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0 px-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tasks text-white text-sm"></i>
                        </div>
                        <h1 class="text-xl font-bold text-gray-900">TaskCheck</h1>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-8 flex-1 px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-chart-pie mr-3 text-sm"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.lists.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.lists.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-list-ul mr-3 text-sm"></i>
                        Task Lists
                    </a>
                    
                    <a href="{{ route('admin.submissions.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.submissions.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-paper-plane mr-3 text-sm"></i>
                        Submissions
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-users mr-3 text-sm"></i>
                        Users
                    </a>
                    
                    <a href="{{ route('admin.weekly-overview') }}" class="group flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-150 {{ request()->routeIs('admin.weekly-overview') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
                        <i class="fas fa-calendar-week mr-3 text-sm"></i>
                        Weekly Overview
                    </a>
                </nav>

                <!-- User section -->
                <div class="flex-shrink-0 border-t border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-gray-400 to-gray-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-white text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-150" title="Logout">
                                <i class="fas fa-sign-out-alt text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top navigation -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <!-- Mobile menu button -->
                    <button class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100" id="mobile-menu-button">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Breadcrumb -->
                    <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                        <i class="fas fa-home"></i>
                        <span>/</span>
                        <span class="text-gray-900 font-medium">@yield('page-title', 'Dashboard')</span>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-3">
                        <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-150" title="Notifications">
                            <i class="fas fa-bell"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600 transition-colors duration-150" title="Settings">
                            <i class="fas fa-cog"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto">
                <div class="p-6">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                                <p class="text-green-800">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-400 mr-3"></i>
                                <p class="text-red-800">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Page header -->
                    @hasSection('header')
                        <div class="mb-8">
                            @yield('header')
                        </div>
                    @endif

                    <!-- Content -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile menu overlay -->
    <div class="md:hidden fixed inset-0 z-50 hidden" id="mobile-menu-overlay">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
        <div class="fixed inset-y-0 left-0 w-64 bg-white">
            <!-- Mobile menu content (same as sidebar) -->
        </div>
    </div>

    <script>
        // Simple mobile menu toggle
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            document.getElementById('mobile-menu-overlay')?.classList.toggle('hidden');
        });
    </script>
</body>
</html>