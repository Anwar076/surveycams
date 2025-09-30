<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - {{ config('app.name', 'TaskCheck') }}</title>

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
        @keyframes fadeUp { from { opacity:0; transform:translateY(30px);} to {opacity:1; transform:translateY(0);} }
        @keyframes fadeIn { from { opacity:0;} to {opacity:1;} }
        @keyframes float { 0%,100% {transform:translateY(0);} 50% {transform:translateY(-8px);} }

        .fade-up { animation: fadeUp 0.9s ease-out forwards; }
        .fade-in { animation: fadeIn 1s ease-out forwards; }
        .float { animation: float 6s ease-in-out infinite; }

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
                <a href="{{ url('/') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold">TaskCheck</span>
                </a>
            </div>
            <div class="flex items-center space-x-6">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-primary-600 font-medium">Home</a>
                <a href="{{ url('/features') }}" class="text-gray-700 hover:text-primary-600 font-medium">Features</a>
                <a href="{{ url('/pricing') }}" class="text-gray-700 hover:text-primary-600 font-medium">Pricing</a>
                <a href="{{ url('/about') }}" class="text-primary-600 font-medium">About</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-primary-600 font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-gradient text-white px-5 py-2 rounded-lg font-medium">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="pt-32 pb-20 text-center relative overflow-hidden">
        <div class="absolute top-10 -left-20 w-64 h-64 bg-blue-400/20 rounded-full blur-3xl float"></div>
        <div class="absolute bottom-10 -right-20 w-72 h-72 bg-purple-400/20 rounded-full blur-3xl float" style="animation-delay:3s;"></div>

        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-4xl sm:text-6xl font-extrabold leading-tight fade-up">
                About <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">TaskCheck</span>
            </h1>
            <p class="mt-6 text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto fade-up" style="animation-delay:0.3s;">
                We're on a mission to revolutionize how teams manage tasks and collaborate. Learn more about our story, values, and the people behind TaskCheck.
            </p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="fade-up">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Our Story</h2>
                <p class="text-lg text-gray-600 mb-6">
                    TaskCheck was born from a simple observation: most task management tools are either too complex or too basic. We saw teams struggling with clunky interfaces, missing features, and poor collaboration tools.
                </p>
                <p class="text-lg text-gray-600 mb-6">
                    Founded in 2020 by a team of productivity enthusiasts and software engineers, we set out to create a platform that would be both powerful and intuitive. Our goal was to build something that teams would actually want to use every day.
                </p>
                <p class="text-lg text-gray-600">
                    Today, TaskCheck serves thousands of teams worldwide, from startups to Fortune 500 companies. We're proud to be part of their success stories and continue to innovate based on their feedback.
                </p>
            </div>
            <div class="fade-up" style="animation-delay:0.2s;">
                <div class="bg-white/70 backdrop-blur-md rounded-2xl p-8">
                    <div class="grid grid-cols-2 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-blue-600 mb-2">1,247+</div>
                            <div class="text-gray-600">Active Users</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-green-600 mb-2">342</div>
                            <div class="text-gray-600">Teams</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-purple-600 mb-2">15,892</div>
                            <div class="text-gray-600">Tasks Completed</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-orange-600 mb-2">99.9%</div>
                            <div class="text-gray-600">Uptime</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission -->
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Our Mission & Values</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">What drives us every day</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.2s;">
                <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Simplicity</h3>
                <p class="text-gray-600">We believe powerful tools should be simple to use. No complex workflows or confusing interfaces.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.4s;">
                <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Collaboration</h3>
                <p class="text-gray-600">Great work happens when teams work together seamlessly. We build tools that enhance collaboration.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.6s;">
                <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl shadow-md">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-4">Innovation</h3>
                <p class="text-gray-600">We're constantly pushing boundaries and exploring new ways to make task management better.</p>
            </div>
        </div>
    </section>

    <!-- Team -->
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">The passionate people behind TaskCheck</p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.2s;">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    SM
                </div>
                <h3 class="text-xl font-semibold mb-2">Sarah Mitchell</h3>
                <p class="text-blue-600 font-medium mb-4">CEO & Co-Founder</p>
                <p class="text-gray-600">Former product manager at Google. Passionate about building tools that make work more enjoyable.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.4s;">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    MJ
                </div>
                <h3 class="text-xl font-semibold mb-2">Michael Johnson</h3>
                <p class="text-green-600 font-medium mb-4">CTO & Co-Founder</p>
                <p class="text-gray-600">Full-stack engineer with 10+ years experience. Loves solving complex problems with elegant solutions.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.6s;">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    AL
                </div>
                <h3 class="text-xl font-semibold mb-2">Anna Lee</h3>
                <p class="text-purple-600 font-medium mb-4">Head of Design</p>
                <p class="text-gray-600">UX designer focused on creating intuitive and beautiful user experiences. Former designer at Apple.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:0.8s;">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    DC
                </div>
                <h3 class="text-xl font-semibold mb-2">David Chen</h3>
                <p class="text-orange-600 font-medium mb-4">Lead Developer</p>
                <p class="text-gray-600">Backend specialist with expertise in scalable systems. Ensures TaskCheck runs smoothly for all users.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:1.0s;">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-teal-500 to-cyan-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    ER
                </div>
                <h3 class="text-xl font-semibold mb-2">Emily Rodriguez</h3>
                <p class="text-teal-600 font-medium mb-4">Head of Marketing</p>
                <p class="text-gray-600">Growth marketing expert who helps teams discover TaskCheck. Former marketing lead at Slack.</p>
            </div>
            
            <div class="card-hover bg-white/70 backdrop-blur-md rounded-2xl p-8 text-center fade-up" style="animation-delay:1.2s;">
                <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    JT
                </div>
                <h3 class="text-xl font-semibold mb-2">James Thompson</h3>
                <p class="text-indigo-600 font-medium mb-4">Customer Success</p>
                <p class="text-gray-600">Dedicated to ensuring every customer gets the most value from TaskCheck. Your success is our success.</p>
            </div>
        </div>
    </section>

    <!-- Company Culture -->
    <section class="max-w-6xl mx-auto px-6 py-20">
        <div class="text-center mb-16 fade-up">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">Our Culture</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">What it's like to work at TaskCheck</p>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="fade-up">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Remote-First & Flexible</h3>
                <p class="text-lg text-gray-600 mb-6">
                    We believe great work can happen anywhere. Our team is distributed across the globe, and we've built our culture around flexibility and trust.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Flexible working hours
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Work from anywhere
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Annual team retreats
                    </li>
                    <li class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Learning & development budget
                    </li>
                </ul>
            </div>
            <div class="fade-up" style="animation-delay:0.2s;">
                <div class="bg-white/70 backdrop-blur-md rounded-2xl p-8">
                    <h4 class="text-xl font-semibold mb-4">Join Our Team</h4>
                    <p class="text-gray-600 mb-6">We're always looking for talented people to join our mission. Check out our open positions.</p>
                    <a href="#" class="btn-gradient text-white px-6 py-3 rounded-lg font-semibold inline-block">
                        View Open Positions
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="text-center py-20 fade-up">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-6">Ready to Get Started?</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Join thousands of teams who trust TaskCheck to manage their workflows and boost productivity.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ url('/pricing') }}" class="btn-gradient text-white px-8 py-4 rounded-lg font-semibold text-lg">
                    View Pricing Plans
                </a>
                <a href="{{ url('/contact') }}" class="bg-white text-gray-700 px-8 py-4 rounded-lg font-semibold text-lg border border-gray-300 hover:bg-gray-50 transition-colors">
                    Contact Sales
                </a>
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
                        <li><a href="{{ url('/features') }}" class="hover:text-blue-600 transition-colors">Features</a></li>
                        <li><a href="{{ url('/pricing') }}" class="hover:text-blue-600 transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Integrations</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Company</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ url('/about') }}" class="hover:text-blue-600 transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Careers</a></li>
                        <li><a href="{{ url('/contact') }}" class="hover:text-blue-600 transition-colors">Contact</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Support</h3>
                    <ul class="space-y-2 text-gray-600">
                        <li><a href="{{ url('/help') }}" class="hover:text-blue-600 transition-colors">Help Center</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Status</a></li>
                        <li><a href="#" class="hover:text-blue-600 transition-colors">Security</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-200 pt-8 text-center text-gray-600">
                <p>© {{ date('Y') }} TaskCheck. Built with <span class="text-red-500">♥</span> Laravel & Tailwind CSS.</p>
            </div>
        </div>
    </footer>
</body>
</html>
