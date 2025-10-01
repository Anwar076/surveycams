<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Security - {{ config('app.name', 'TaskCheck') }}</title>

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
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold">TaskCheck Security</span>
            </div>
            <a href="{{ route('welcome') }}" class="text-gray-600 hover:text-blue-600">← Back to TaskCheck</a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Security & Compliance</h1>
            <p class="text-lg text-gray-600">Your data security is our top priority. Learn about our comprehensive security measures and compliance standards.</p>
        </div>

        <!-- Security Overview -->
        <div class="bg-white rounded-lg shadow-sm border p-8 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900">Enterprise-Grade Security</h2>
                    <p class="text-gray-600">Bank-level security measures protect your data 24/7</p>
                </div>
            </div>
        </div>

        <!-- Security Features -->
        <div class="grid md:grid-cols-2 gap-8 mb-12">
            <!-- Data Encryption -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Data Encryption</h3>
                <ul class="space-y-2 text-gray-600">
                    <li>• AES-256 encryption at rest</li>
                    <li>• TLS 1.3 encryption in transit</li>
                    <li>• End-to-end encryption for sensitive data</li>
                    <li>• Key management with HSM</li>
                </ul>
            </div>

            <!-- Access Control -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Access Control</h3>
                <ul class="space-y-2 text-gray-600">
                    <li>• Multi-factor authentication (MFA)</li>
                    <li>• Role-based access control (RBAC)</li>
                    <li>• Single sign-on (SSO) support</li>
                    <li>• Session management and timeout</li>
                </ul>
            </div>

            <!-- Infrastructure Security -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Infrastructure Security</h3>
                <ul class="space-y-2 text-gray-600">
                    <li>• SOC 2 Type II certified</li>
                    <li>• ISO 27001 compliant</li>
                    <li>• Regular security audits</li>
                    <li>• 24/7 security monitoring</li>
                </ul>
            </div>

            <!-- Data Protection -->
            <div class="bg-white rounded-lg shadow-sm border p-6">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Data Protection</h3>
                <ul class="space-y-2 text-gray-600">
                    <li>• GDPR compliant</li>
                    <li>• CCPA compliant</li>
                    <li>• Data residency options</li>
                    <li>• Right to deletion</li>
                </ul>
            </div>
        </div>

        <!-- Compliance Certifications -->
        <div class="bg-white rounded-lg shadow-sm border p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Compliance & Certifications</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">SOC 2 Type II</h3>
                    <p class="text-sm text-gray-600">Security, availability, and confidentiality</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">ISO 27001</h3>
                    <p class="text-sm text-gray-600">Information security management</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">GDPR</h3>
                    <p class="text-sm text-gray-600">Data protection regulation</p>
                </div>
            </div>
        </div>

        <!-- Security Practices -->
        <div class="bg-white rounded-lg shadow-sm border p-8 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Security Practices</h2>
            <div class="space-y-6">
                <div class="border-l-4 border-blue-500 pl-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Regular Security Audits</h3>
                    <p class="text-gray-600">We conduct comprehensive security audits quarterly, including penetration testing, vulnerability assessments, and code reviews by third-party security experts.</p>
                </div>
                <div class="border-l-4 border-green-500 pl-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Incident Response</h3>
                    <p class="text-gray-600">Our 24/7 security team monitors for threats and responds to incidents within minutes. We maintain detailed incident response procedures and regularly test our response capabilities.</p>
                </div>
                <div class="border-l-4 border-purple-500 pl-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Employee Training</h3>
                    <p class="text-gray-600">All employees undergo regular security training, including phishing awareness, secure coding practices, and data handling procedures.</p>
                </div>
                <div class="border-l-4 border-orange-500 pl-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Data Backup & Recovery</h3>
                    <p class="text-gray-600">We maintain encrypted backups in multiple geographic locations with tested recovery procedures to ensure business continuity.</p>
                </div>
            </div>
        </div>

        <!-- Security Contact -->
        <div class="bg-blue-50 rounded-lg border border-blue-200 p-8 text-center">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Report Security Issues</h2>
            <p class="text-gray-600 mb-6">If you discover a security vulnerability, please report it to our security team immediately.</p>
            <div class="space-y-4">
                <a href="mailto:security@taskcheck.com" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    security@taskcheck.com
                </a>
                <p class="text-sm text-gray-600">We respond to security reports within 24 hours</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-12 text-gray-600">
            <p>Last updated: {{ date('F j, Y') }}</p>
            <p class="mt-2">Questions about security? Contact our <a href="{{ route('contact') }}" class="text-blue-600 hover:underline">support team</a></p>
        </div>
    </div>
</body>
</html>
