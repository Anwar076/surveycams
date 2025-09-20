<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Employee Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#3b82f6">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 min-h-screen">
    <div class="flex flex-col min-h-screen">
        <!-- Modern Navigation -->
        <nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-slate-200/50 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Enhanced Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('employee.dashboard') }}" class="flex items-center space-x-3 group">
                                <div class="h-10 w-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300 group-hover:scale-105">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                <span class="text-xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                                    TaskCheck
                                </span>
                            </a>
                        </div>

                        <!-- Enhanced Navigation Links -->
                        <div class="hidden lg:ml-10 lg:flex lg:space-x-2">
                            <a href="{{ route('employee.dashboard') }}" 
                               class="group flex items-center px-4 py-2 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('employee.dashboard') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('employee.lists.index') }}" 
                               class="group flex items-center px-4 py-2 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('employee.lists.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                My Tasks
                            </a>
                            <a href="{{ route('employee.notifications.index') }}" 
                               class="group flex items-center px-4 py-2 text-sm font-semibold rounded-2xl transition-all duration-300 relative {{ request()->routeIs('employee.notifications.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6a2 2 0 012 2v9a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                                </svg>
                                Notifications
                                @php
                                    $unreadCount = auth()->user()->unreadNotifications()->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute -top-1 -right-1 inline-flex items-center justify-center h-5 w-5 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg animate-pulse">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                @endif
                            </a>
                        </div>
                    </div>

                    <!-- Enhanced User Menu -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-4">
                        <div class="flex items-center space-x-3 text-sm">
                            <div class="h-10 w-10 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-slate-800">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-slate-500">Employee</div>
                            </div>
                        </div>
                        <div class="h-8 w-px bg-slate-300"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-600 hover:text-red-600 hover:bg-red-50 rounded-2xl transition-all duration-300">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>

                    <!-- Enhanced Mobile menu button -->
                    <div class="lg:hidden flex items-center">
                        <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-3 rounded-2xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 transition-all duration-300">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Enhanced Mobile Menu -->
            <div class="mobile-menu hidden lg:hidden bg-white/95 backdrop-blur-md border-t border-slate-200/50 shadow-xl">
                <div class="px-6 py-4 space-y-2">
                    <a href="{{ route('employee.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-2xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('employee.dashboard') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('employee.lists.index') }}" 
                       class="flex items-center px-4 py-3 rounded-2xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('employee.lists.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                        My Tasks
                    </a>
                    <a href="{{ route('employee.notifications.index') }}" 
                       class="flex items-center justify-between px-4 py-3 rounded-2xl text-base font-semibold transition-all duration-300 {{ request()->routeIs('employee.notifications.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' }}">
                        <div class="flex items-center">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6a2 2 0 012 2v9a2 2 0 01-2 2H9a2 2 0 01-2-2V9a2 2 0 012-2z"></path>
                            </svg>
                            Notifications
                        </div>
                        @php
                            $unreadCount = auth()->user()->unreadNotifications()->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="inline-flex items-center justify-center h-6 w-6 text-xs font-bold text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-full shadow-lg animate-pulse">
                                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                            </span>
                        @endif
                    </a>
                </div>
                <div class="px-6 py-4 border-t border-slate-200/50 bg-gradient-to-r from-slate-50 to-blue-50">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="h-12 w-12 rounded-2xl bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold shadow-lg">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div>
                            <div class="text-base font-bold text-slate-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 text-base font-semibold text-red-600 hover:bg-red-50 rounded-2xl transition-all duration-300 border border-red-200 hover:border-red-300">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Enhanced Flash Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-4 shadow-lg animate-slide-down">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 rounded-2xl flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl p-4 shadow-lg animate-slide-down">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-100 rounded-2xl flex items-center justify-center mr-3">
                                <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- Enhanced Footer -->
        <footer class="bg-white/80 backdrop-blur-md border-t border-slate-200/50 py-8 mt-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <div class="flex items-center justify-center mb-4">
                        <div class="h-8 w-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <span class="text-lg font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">
                            TaskCheck
                        </span>
                    </div>
                    <p class="text-sm text-slate-500 mb-2">Employee Portal</p>
                    <p class="text-xs text-slate-400">&copy; {{ date('Y') }} TaskCheck. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        // Enhanced Mobile menu toggle with animations
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                    
                    // Add smooth animation
                    if (!mobileMenu.classList.contains('hidden')) {
                        mobileMenu.style.opacity = '0';
                        mobileMenu.style.transform = 'translateY(-10px)';
                        mobileMenu.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                        
                        requestAnimationFrame(() => {
                            mobileMenu.style.opacity = '1';
                            mobileMenu.style.transform = 'translateY(0)';
                        });
                    }
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }

            // Enhanced flash messages with better animations
            setTimeout(function() {
                const flashMessages = document.querySelectorAll('.animate-slide-down');
                if (flashMessages.length > 0) {
                    flashMessages.forEach(function(message) {
                        if (message && message.style) {
                            message.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                            message.style.opacity = '0';
                            message.style.transform = 'translateY(-10px)';
                            setTimeout(function() {
                                if (message && message.parentNode) {
                                    message.remove();
                                }
                            }, 500);
                        }
                    });
                }
            }, 5000);

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Add touch feedback for mobile interactions
            document.addEventListener('touchstart', function(e) {
                const element = e.target.closest('button, a');
                if (element && element.style) {
                    element.style.transform = 'scale(0.98)';
                }
            });

            document.addEventListener('touchend', function(e) {
                const element = e.target.closest('button, a');
                if (element && element.style) {
                    setTimeout(() => {
                        if (element && element.style) {
                            element.style.transform = '';
                        }
                    }, 150);
                }
            });

            // Add loading states for form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                if (form) {
                    form.addEventListener('submit', function() {
                        const submitButton = form.querySelector('button[type="submit"]');
                        if (submitButton) {
                            submitButton.disabled = true;
                            const originalText = submitButton.innerHTML;
                            submitButton.innerHTML = '<svg class="w-4 h-4 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Processing...';
                            
                            // Re-enable after 5 seconds as fallback
                            setTimeout(() => {
                                if (submitButton) {
                                    submitButton.disabled = false;
                                    submitButton.innerHTML = originalText;
                                }
                            }, 5000);
                        }
                    });
                }
            });

            // Add intersection observer for scroll animations
            if (typeof IntersectionObserver !== 'undefined') {
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && entry.target && entry.target.style) {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }
                    });
                }, observerOptions);

                // Observe elements for scroll animations
                const animatedElements = document.querySelectorAll('.animate-slide-down');
                animatedElements.forEach(element => {
                    if (element && element.style) {
                        element.style.opacity = '0';
                        element.style.transform = 'translateY(-20px)';
                        element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                        observer.observe(element);
                    }
                });
            }
        });

        // Add CSS animations
        if (document.head) {
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slide-down {
                    from {
                        opacity: 0;
                        transform: translateY(-20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }
                
                .animate-slide-down {
                    animation: slide-down 0.6s ease-out;
                }
                
                /* Smooth transitions for all interactive elements */
                button, a, input, select, textarea {
                    transition: all 0.2s ease-in-out;
                }
                
                /* Enhanced focus states */
                button:focus, a:focus, input:focus, select:focus, textarea:focus {
                    outline: 2px solid #3b82f6;
                    outline-offset: 2px;
                }
                
                /* Mobile-specific improvements */
                @media (max-width: 768px) {
                    .mobile-menu {
                        backdrop-filter: blur(10px);
                    }
                }
            `;
            document.head.appendChild(style);
        }
    </script>
</body>
</html>