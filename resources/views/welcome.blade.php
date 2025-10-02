<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'TaskCheck') }}</title>

    <!-- PWA Meta Tags -->
    <meta name="description" content="Professional task management and team collaboration platform">
    <meta name="theme-color" content="#2563eb">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="TaskCheck">
    <meta name="msapplication-TileColor" content="#2563eb">
    <meta name="msapplication-tap-highlight" content="no">

    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('icons/icon-32x32.png') }}">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/icons/icon-192x192.png">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="/icons/icon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/icons/icon-16x16.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'ui-sans-serif', 'system-ui'],
                    },
                    colors: {
                        primary: {
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Animations */
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
        @keyframes fadeIn { from { opacity:0;} to {opacity:1;} }
        @keyframes float { 0%,100% {transform:translateY(0);} 50% {transform:translateY(-8px);} }

        .fade-up { animation: fadeUp 0.9s ease-out forwards; }
        .fade-in { animation: fadeIn 1s ease-out forwards; }
        .float { animation: float 6s ease-in-out infinite; }

        /* Hover effects */
        .card-hover { transition: all 0.35s ease; }
        .card-hover:hover { transform: translateY(-6px) scale(1.02); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }

        .btn-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(139,92,246,0.35);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 min-h-screen font-sans text-gray-900">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-md border-b border-gray-200/40">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 
                              0 002 2h10a2 2 0 002-2V7a2 2 
                              0 00-2-2h-2M9 5a2 2 0 002 
                              2h2a2 2 0 002-2M9 5a2 2 
                              0 012-2h2a2 2 0 012 2m-6 
                              9l2 2 4-4"></path>
                    </svg>
                </div>
                <span class="text-xl font-extrabold">TaskCheck</span>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('features') }}" class="text-gray-700 hover:text-primary-600 font-medium">Features</a>
                <a href="{{ route('pricing') }}" class="text-gray-700 hover:text-primary-600 font-medium">Pricing</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary-600 font-medium">About</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-primary-600 font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-gradient text-white px-5 py-2 rounded-lg font-medium">Login</a>
                    @endauth
                @endif
                <button id="install-button" class="hidden bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Install App
                </button>
                <button id="install-button-always" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Add to Home Screen
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="md:hidden bg-white border-t border-gray-200 hidden">
            <div class="px-6 py-4 space-y-4">
                <a href="{{ route('features') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Features</a>
                <a href="{{ route('pricing') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Pricing</a>
                <a href="{{ route('about') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">About</a>
                <a href="{{ route('blog') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Blog</a>
                <a href="{{ route('careers') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Careers</a>
                <a href="{{ route('help') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Help</a>
                <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Contact</a>
                <button id="install-button-mobile" class="hidden w-full text-left bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Install App
                </button>
                <button id="install-button-mobile-always" class="w-full text-left bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Add to Home Screen
                </button>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block text-gray-700 hover:text-primary-600 font-medium py-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block btn-gradient text-white px-4 py-2 rounded-lg font-medium text-center">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="pt-32 pb-20 text-center relative overflow-hidden">
        <!-- Floating shapes -->
        <div class="absolute top-10 -left-20 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl float"></div>
        <div class="absolute bottom-10 -right-20 w-72 h-72 bg-purple-400/20 rounded-full blur-3xl float" style="animation-delay:3s;"></div>

        <div class="max-w-5xl mx-auto px-4">
            <h1 class="text-4xl sm:text-6xl font-extrabold leading-tight fade-up">
                Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">TaskCheck</span>
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-gray-600 max-w-3xl mx-auto fade-up" style="animation-delay:0.3s;">
                The ultimate task management platform for modern teams. Streamline workflows, boost productivity, and achieve your goals with powerful collaboration tools.
            </p>
            
            <!-- Live Stats -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto fade-up" style="animation-delay:0.6s;">
                <div class="bg-white/70 backdrop-blur-md rounded-xl p-4 shadow-lg">
                    <div class="text-2xl font-bold text-blue-600" id="live-users">1,247</div>
                    <div class="text-sm text-gray-600">Active Users</div>
                </div>
                <div class="bg-white/70 backdrop-blur-md rounded-xl p-4 shadow-lg">
                    <div class="text-2xl font-bold text-green-600" id="live-tasks">15,892</div>
                    <div class="text-sm text-gray-600">Tasks Completed</div>
                </div>
                <div class="bg-white/70 backdrop-blur-md rounded-xl p-4 shadow-lg">
                    <div class="text-2xl font-bold text-purple-600" id="live-teams">342</div>
                    <div class="text-sm text-gray-600">Teams Using</div>
                </div>
                <div class="bg-white/70 backdrop-blur-md rounded-xl p-4 shadow-lg">
                    <div class="text-2xl font-bold text-orange-600" id="live-hours">2,847</div>
                    <div class="text-sm text-gray-600">Hours Saved</div>
                </div>
            </div>
            
            <!-- PWA Install Section -->
            <div class="mt-12 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 fade-up" style="animation-delay:0.9s;">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">📱 Install TaskCheck App</h3>
                    <p class="text-gray-600 mb-4">Get quick access with our mobile app. Works on all devices!</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <button id="install-hero-button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all hover:scale-105">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Install App
                        </button>
                        <div class="text-sm text-gray-500 flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Works on iPhone, Android, Desktop & iPad
                        </div>
                    </div>
                    
                    <!-- Mobile-specific instructions -->
                    <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="text-sm text-yellow-800">
                            <strong>📱 On Mobile:</strong> This creates a <strong>real app</strong> without the browser address bar - just like a native app!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Powerful Features for Modern Teams</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Everything you need to manage tasks, collaborate effectively, and achieve your goals.</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.2s;">
                <div class="w-16 h-16 mb-6 flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Smart Task Management</h3>
                <p class="text-gray-600">Create, assign, and track tasks with intelligent prioritization and deadline management.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.4s;">
                <div class="w-16 h-16 mb-6 flex items-center justify-center bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Team Collaboration</h3>
                <p class="text-gray-600">Work together seamlessly with real-time updates, comments, and file sharing.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.6s;">
                <div class="w-16 h-16 mb-6 flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Advanced Analytics</h3>
                <p class="text-gray-600">Get insights into team performance with detailed reports and productivity metrics.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.8s;">
                <div class="w-16 h-16 mb-6 flex items-center justify-center bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Time Tracking</h3>
                <p class="text-gray-600">Monitor time spent on tasks and projects with built-in time tracking tools.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:1.0s;">
                <div class="w-16 h-16 mb-6 flex items-center justify-center bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-6H4v6zM4 13h6V7H4v6zM4 5h6V1H4v4zM10 3h4v4h-4V3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Custom Workflows</h3>
                <p class="text-gray-600">Create custom workflows and automation rules to streamline your processes.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:1.2s;">
                <div class="w-16 h-16 mb-6 flex items-center justify-center bg-gradient-to-r from-teal-500 to-cyan-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Secure & Reliable</h3>
                <p class="text-gray-600">Enterprise-grade security with 99.9% uptime guarantee and data encryption.</p>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Choose Your Perfect Plan</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Flexible pricing options to fit teams of all sizes. Start free and scale as you grow.</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Starter Plan -->
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 relative fade-up" style="animation-delay:0.2s;">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Starter</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-4">$29<span class="text-lg text-gray-500">/month</span></div>
                    <p class="text-gray-600 mb-6">Perfect for small teams getting started</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        1 Admin Account
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        5 Employee Accounts
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Basic Task Management
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Email Support
                    </li>
                </ul>
                <button class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                    Get Started
                </button>
            </div>
            
            <!-- Professional Plan -->
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 relative border-2 border-blue-500 fade-up" style="animation-delay:0.4s;">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-blue-500 text-white px-4 py-1 rounded-full text-sm font-semibold">Most Popular</span>
                </div>
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Professional</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-4">$79<span class="text-lg text-gray-500">/month</span></div>
                    <p class="text-gray-600 mb-6">Ideal for growing teams</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        2 Admin Accounts
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        10 Employee Accounts
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Advanced Analytics
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Priority Support
                    </li>
                </ul>
                <button class="w-full btn-gradient text-white py-3 rounded-lg font-semibold">
                    Get Started
                </button>
            </div>
            
            <!-- Enterprise Plan -->
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 relative fade-up" style="animation-delay:0.6s;">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Enterprise</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-4">$149<span class="text-lg text-gray-500">/month</span></div>
                    <p class="text-gray-600 mb-6">For large organizations</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        5 Admin Accounts
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        20 Employee Accounts
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Custom Workflows
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        24/7 Phone Support
                    </li>
                </ul>
                <button class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                    Get Started
                </button>
            </div>
            
            <!-- Custom Plan -->
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 relative fade-up" style="animation-delay:0.8s;">
                <div class="text-center">
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Custom</h3>
                    <div class="text-4xl font-bold text-blue-600 mb-4">Custom<span class="text-lg text-gray-500">/month</span></div>
                    <p class="text-gray-600 mb-6">Tailored to your needs</p>
                </div>
                <ul class="space-y-3 mb-8">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Unlimited Admins
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Unlimited Employees
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        White-label Solution
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Dedicated Manager
                    </li>
                </ul>
                <button class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                    Contact Sales
                </button>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="text-center py-20 fade-up" style="animation-delay:1s;">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn-gradient text-white px-10 py-4 rounded-full font-semibold text-lg inline-flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
                Go to Dashboard
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-gradient text-white px-10 py-4 rounded-full font-semibold text-lg inline-flex items-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path>
                </svg>
                Get Started
            </a>
        @endauth
        <p class="mt-6 text-gray-600">Need an account? Contact: <a href="mailto:admin@taskcheck.com" class="text-primary-600 font-medium hover:underline">admin@taskcheck.com</a></p>
    </section>

    <!-- Testimonials -->
    <section class="max-w-7xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">What Our Customers Say</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Join thousands of teams who trust TaskCheck to manage their workflows.</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.2s;">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold">
                        SM
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Sarah Mitchell</h4>
                        <p class="text-sm text-gray-600">CEO, TechStart Inc.</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"TaskCheck has revolutionized how our team manages projects. The interface is intuitive and the analytics help us stay on track."</p>
                <div class="flex text-yellow-400 mt-4">
                    ★★★★★
                </div>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.4s;">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                        MJ
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Michael Johnson</h4>
                        <p class="text-sm text-gray-600">Project Manager, DesignCo</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"The real-time collaboration features are game-changing. Our team productivity has increased by 40% since we started using TaskCheck."</p>
                <div class="flex text-yellow-400 mt-4">
                    ★★★★★
                </div>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 fade-up" style="animation-delay:0.6s;">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white font-bold">
                        AL
                    </div>
                    <div class="ml-4">
                        <h4 class="font-semibold text-gray-900">Anna Lee</h4>
                        <p class="text-sm text-gray-600">Operations Director, GrowthCorp</p>
                    </div>
                </div>
                <p class="text-gray-600 italic">"The custom workflows and automation have saved us countless hours. TaskCheck scales perfectly with our growing team."</p>
                <div class="flex text-yellow-400 mt-4">
                    ★★★★★
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="max-w-4xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
            <p class="text-lg text-gray-600">Everything you need to know about TaskCheck</p>
        </div>
        
        <div class="space-y-6">
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-6 fade-up" style="animation-delay:0.2s;">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">How does the pricing work?</h3>
                <p class="text-gray-600">Our pricing is based on the number of admin and employee accounts. You can upgrade or downgrade your plan at any time.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-6 fade-up" style="animation-delay:0.4s;">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Is there a free trial?</h3>
                <p class="text-gray-600">Yes! We offer a 14-day free trial for all plans. No credit card required to get started.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-6 fade-up" style="animation-delay:0.6s;">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Can I customize my subscription?</h3>
                <p class="text-gray-600">Absolutely! Our Custom plan allows you to create a subscription tailored to your specific needs with unlimited users and custom features.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-6 fade-up" style="animation-delay:0.8s;">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">What kind of support do you offer?</h3>
                <p class="text-gray-600">We provide email support for all plans, priority support for Professional, and 24/7 phone support for Enterprise and Custom plans.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-gray-900">TaskCheck</span>
                    </div>
                    <p class="text-gray-600">The ultimate task management platform for modern teams.</p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Product</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ route('features') }}" class="hover:text-blue-600 transition-colors">Features</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-blue-600 transition-colors">Pricing</a></li>
                        <li><a href="{{ route('integrations') }}" class="hover:text-blue-600 transition-colors">Integrations</a></li>
                        <li><a href="{{ route('api') }}" class="hover:text-blue-600 transition-colors">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ route('about') }}" class="hover:text-blue-600 transition-colors">About</a></li>
                        <li><a href="{{ route('blog') }}" class="hover:text-blue-600 transition-colors">Blog</a></li>
                        <li><a href="{{ route('careers') }}" class="hover:text-blue-600 transition-colors">Careers</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-blue-600 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ route('help') }}" class="hover:text-blue-600 transition-colors">Help Center</a></li>
                        <li><a href="{{ route('documentation') }}" class="hover:text-blue-600 transition-colors">Documentation</a></li>
                        <li><a href="{{ route('status') }}" class="hover:text-blue-600 transition-colors">Status</a></li>
                        <li><a href="{{ route('security') }}" class="hover:text-blue-600 transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-8 text-center text-gray-600">
                <p>© {{ date('Y') }} TaskCheck. Built with <span class="text-red-500">♥</span> Laravel & Tailwind CSS.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript for Live Numbers -->
    <script>
        // Animate live numbers
        function animateNumber(element, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                const current = Math.floor(progress * (end - start) + start);
                element.textContent = current.toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Start animations when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                animateNumber(document.getElementById('live-users'), 0, 1247, 2000);
                animateNumber(document.getElementById('live-tasks'), 0, 15892, 2500);
                animateNumber(document.getElementById('live-teams'), 0, 342, 1800);
                animateNumber(document.getElementById('live-hours'), 0, 2847, 2200);
            }, 1000);

            // Mobile menu functionality
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');

            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenuBtn.contains(e.target) && !mobileMenu.contains(e.target)) {
                    mobileMenu.classList.add('hidden');
                }
            });
        });

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('SW registered: ', registration);
                    })
                    .catch((registrationError) => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }

        // PWA Install Prompt
        let deferredPrompt;
        const installButton = document.getElementById('install-button');
        const installButtonMobile = document.getElementById('install-button-mobile');
        const installButtonAlways = document.getElementById('install-button-always');
        const installButtonMobileAlways = document.getElementById('install-button-mobile-always');
        const installHeroButton = document.getElementById('install-hero-button');

        // Function to show install instructions
        function showInstallInstructions() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);
            const isDesktop = !isIOS && !isAndroid;

            let instructions = '';
            
            if (isIOS) {
                instructions = 'To install as a real app:\n1. Tap the Share button (📤) in Safari\n2. Scroll down and tap "Add to Home Screen"\n3. Tap "Add" to confirm\n\nThis will create a real app without the address bar!';
            } else if (isAndroid) {
                instructions = 'To install as a real app:\n1. Tap the menu (⋮) in Chrome\n2. Tap "Add to Home Screen" or "Install App"\n3. Tap "Install" to confirm\n\nThis will create a real app without the address bar!';
            } else {
                instructions = 'To install: Click the install button in your browser\'s address bar, or use the browser menu';
            }

            alert(`📱 Install TaskCheck App\n\n${instructions}\n\nOr look for the install option in your browser menu.`);
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            // Prevent the mini-infobar from appearing on mobile
            e.preventDefault();
            // Stash the event so it can be triggered later
            deferredPrompt = e;
            // Show the install buttons
            if (installButton) {
                installButton.style.display = 'block';
            }
            if (installButtonMobile) {
                installButtonMobile.style.display = 'block';
            }
            if (installHeroButton) {
                installHeroButton.textContent = 'Install App';
            }
        });

        function handleInstall() {
            if (deferredPrompt) {
                // Show the install prompt
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                deferredPrompt.userChoice.then((choiceResult) => {
                    console.log(`User response to the install prompt: ${choiceResult.outcome}`);
                    // Clear the deferredPrompt variable
                    deferredPrompt = null;
                    // Hide the install buttons
                    if (installButton) {
                        installButton.style.display = 'none';
                    }
                    if (installButtonMobile) {
                        installButtonMobile.style.display = 'none';
                    }
                });
            } else {
                // Show instructions if no prompt available
                showInstallInstructions();
            }
        }

        // Add event listeners
        if (installButton) {
            installButton.addEventListener('click', handleInstall);
        }
        if (installButtonMobile) {
            installButtonMobile.addEventListener('click', handleInstall);
        }
        if (installButtonAlways) {
            installButtonAlways.addEventListener('click', showInstallInstructions);
        }
        if (installButtonMobileAlways) {
            installButtonMobileAlways.addEventListener('click', showInstallInstructions);
        }
        if (installHeroButton) {
            installHeroButton.addEventListener('click', handleInstall);
        }

        // Track successful installation
        window.addEventListener('appinstalled', () => {
            console.log('PWA was installed');
            if (installButton) {
                installButton.style.display = 'none';
            }
            if (installButtonMobile) {
                installButtonMobile.style.display = 'none';
            }
            if (installHeroButton) {
                installHeroButton.textContent = 'App Installed!';
                installHeroButton.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                installHeroButton.classList.add('bg-green-600');
            }
        });
    </script>
</body>
</html>
