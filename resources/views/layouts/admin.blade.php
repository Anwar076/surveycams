<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#1e40af">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <div class="min-h-screen flex">
        <!-- Enhanced Sidebar -->
        <div class="hidden md:flex md:w-72 md:flex-col">
            <div class="flex flex-col flex-grow pt-6 overflow-y-auto bg-white/90 backdrop-blur-md shadow-xl border-r border-slate-200/50">
                <!-- Enhanced Logo -->
                <div class="flex items-center flex-shrink-0 px-6 mb-8">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-tasks text-white text-lg"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">TaskCheck</h1>
                            <p class="text-xs text-slate-500 font-medium">Admin Portal</p>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Navigation -->
                <nav class="flex-1 px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-chart-pie mr-3 text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500' }}"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.lists.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.lists.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-list-ul mr-3 text-sm {{ request()->routeIs('admin.lists.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Task Lists
                    </a>
                    
                    <a href="{{ route('admin.submissions.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.submissions.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-paper-plane mr-3 text-sm {{ request()->routeIs('admin.submissions.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Submissions
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-users mr-3 text-sm {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Users
                    </a>
                    
                    <a href="{{ route('admin.weekly-overview') }}" 
                       class="group flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.weekly-overview') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-calendar-week mr-3 text-sm {{ request()->routeIs('admin.weekly-overview') ? 'text-white' : 'text-slate-500' }}"></i>
                        Weekly Overview
                    </a>
                </nav>

                <!-- Enhanced User section -->
                <div class="flex-shrink-0 border-t border-slate-200/50 p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-slate-500 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 font-medium">Administrator</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-3 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-2xl transition-all duration-300" title="Logout">
                                <i class="fas fa-sign-out-alt text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Enhanced Top navigation -->
            <header class="bg-white/80 backdrop-blur-md border-b border-slate-200/50 px-6 py-4 shadow-sm">
                <div class="flex items-center justify-between">
                    <!-- Enhanced Mobile menu button -->
                    <button class="md:hidden p-3 rounded-2xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-all duration-300" id="mobile-menu-button">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                    
                    <!-- Enhanced Breadcrumb -->
                    <div class="hidden md:flex items-center space-x-3 text-sm">
                        <div class="flex items-center space-x-2 text-slate-500">
                            <i class="fas fa-home text-sm"></i>
                            <span>/</span>
                            <span class="text-slate-900 font-semibold">@yield('page-title', 'Dashboard')</span>
                        </div>
                    </div>

                    <!-- Enhanced Actions -->
                    <div class="flex items-center space-x-3">
                        <button class="p-3 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-2xl transition-all duration-300" title="Notifications">
                            <i class="fas fa-bell text-lg"></i>
                        </button>
                        <button class="p-3 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-2xl transition-all duration-300" title="Settings">
                            <i class="fas fa-cog text-lg"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Enhanced Page content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
                <div class="p-6">
                    <!-- Enhanced Flash Messages -->
                    @if (session('success'))
                        <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-4 shadow-lg animate-slide-down">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 rounded-2xl flex items-center justify-center mr-3">
                                    <i class="fas fa-check-circle text-green-600"></i>
                                </div>
                                <p class="text-green-800 font-semibold">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl p-4 shadow-lg animate-slide-down">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 rounded-2xl flex items-center justify-center mr-3">
                                    <i class="fas fa-exclamation-circle text-red-600"></i>
                                </div>
                                <p class="text-red-800 font-semibold">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Enhanced Page header -->
                    @hasSection('header')
                        <div class="mb-8">
                            @yield('header')
                        </div>
                    @endif

                    <!-- Enhanced Content -->
                    <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-xl border border-white/50">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Enhanced Mobile menu overlay -->
    <div class="md:hidden fixed inset-0 z-50 hidden" id="mobile-menu-overlay">
        <div class="fixed inset-0 bg-slate-900/75 backdrop-blur-sm"></div>
        <div class="fixed inset-y-0 left-0 w-80 bg-white/95 backdrop-blur-md shadow-2xl">
            <!-- Mobile menu content -->
            <div class="flex flex-col h-full">
                <!-- Mobile Logo -->
                <div class="flex items-center justify-between p-6 border-b border-slate-200/50">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-tasks text-white text-sm"></i>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">TaskCheck</h1>
                            <p class="text-xs text-slate-500 font-medium">Admin Portal</p>
                        </div>
                    </div>
                    <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all duration-300" id="close-mobile-menu">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- Mobile Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-base font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-chart-pie mr-3 text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-500' }}"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.lists.index') }}" 
                       class="flex items-center px-4 py-3 text-base font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.lists.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-list-ul mr-3 text-sm {{ request()->routeIs('admin.lists.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Task Lists
                    </a>
                    
                    <a href="{{ route('admin.submissions.index') }}" 
                       class="flex items-center px-4 py-3 text-base font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.submissions.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-paper-plane mr-3 text-sm {{ request()->routeIs('admin.submissions.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Submissions
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-4 py-3 text-base font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-users mr-3 text-sm {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Users
                    </a>
                    
                    <a href="{{ route('admin.weekly-overview') }}" 
                       class="flex items-center px-4 py-3 text-base font-semibold rounded-2xl transition-all duration-300 {{ request()->routeIs('admin.weekly-overview') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-lg' : 'text-slate-700 hover:bg-slate-100 hover:text-slate-900' }}">
                        <i class="fas fa-calendar-week mr-3 text-sm {{ request()->routeIs('admin.weekly-overview') ? 'text-white' : 'text-slate-500' }}"></i>
                        Weekly Overview
                    </a>
                </nav>

                <!-- Mobile User section -->
                <div class="border-t border-slate-200/50 p-6">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-slate-500 to-slate-700 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-user text-white text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-slate-500 font-medium">Administrator</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-3 text-base font-semibold text-red-600 hover:bg-red-50 rounded-2xl transition-all duration-300 border border-red-200 hover:border-red-300">
                            <i class="fas fa-sign-out-alt mr-2 text-sm"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced JavaScript -->
    <script>
        // Enhanced Mobile menu toggle with animations
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
            const closeMobileMenu = document.getElementById('close-mobile-menu');
            
            if (mobileMenuButton && mobileMenuOverlay) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenuOverlay.classList.remove('hidden');
                    
                    // Add smooth animation
                    mobileMenuOverlay.style.opacity = '0';
                    mobileMenuOverlay.style.transform = 'translateX(-100%)';
                    mobileMenuOverlay.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
                    
                    requestAnimationFrame(() => {
                        mobileMenuOverlay.style.opacity = '1';
                        mobileMenuOverlay.style.transform = 'translateX(0)';
                    });
                });

                // Close mobile menu
                function closeMenu() {
                    mobileMenuOverlay.style.opacity = '0';
                    mobileMenuOverlay.style.transform = 'translateX(-100%)';
                    setTimeout(() => {
                        mobileMenuOverlay.classList.add('hidden');
                    }, 300);
                }

                if (closeMobileMenu) {
                    closeMobileMenu.addEventListener('click', closeMenu);
                }

                // Close mobile menu when clicking outside
                mobileMenuOverlay.addEventListener('click', function(event) {
                    if (event.target === mobileMenuOverlay) {
                        closeMenu();
                    }
                });

                // Close mobile menu when clicking on navigation links
                const mobileNavLinks = mobileMenuOverlay.querySelectorAll('nav a');
                mobileNavLinks.forEach(link => {
                    link.addEventListener('click', closeMenu);
                });
            }

            // Enhanced flash messages with better animations
            const flashMessages = document.querySelectorAll('.bg-gradient-to-r.animate-slide-down');
            flashMessages.forEach(function(message) {
                // Only apply auto-hide to actual flash messages
                setTimeout(function() {
                    message.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    message.style.opacity = '0';
                    message.style.transform = 'translateY(-10px)';
                    setTimeout(function() {
                        message.remove();
                    }, 500);
                }, 5000);
            });

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';

            // Add touch feedback for mobile interactions
            document.addEventListener('touchstart', function(e) {
                if (e.target.closest('button, a')) {
                    e.target.closest('button, a').style.transform = 'scale(0.98)';
                }
            });

            document.addEventListener('touchend', function(e) {
                if (e.target.closest('button, a')) {
                    setTimeout(() => {
                        e.target.closest('button, a').style.transform = '';
                    }, 150);
                }
            });

            // Add loading states for form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function() {
                    const submitButton = form.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';
                        
                        // Re-enable after 5 seconds as fallback
                        setTimeout(() => {
                            submitButton.disabled = false;
                            submitButton.innerHTML = originalText;
                        }, 5000);
                    }
                });
            });

            // Add intersection observer for scroll animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe elements for scroll animations
            const animatedElements = document.querySelectorAll('.animate-slide-down');
            animatedElements.forEach(element => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(-20px)';
                element.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
                observer.observe(element);
            });
        });

        // Add CSS animations
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
    </script>
</body>
</html>