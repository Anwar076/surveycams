<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskCheck - Task Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col justify-center items-center">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md p-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">TaskCheck</h1>
                <p class="text-gray-600 mb-8">Task & Checklist Management System</p>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Go to Dashboard
                    </a>
                @else
                    <div class="space-y-4">
                        <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                            Login
                        </a>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900 mb-2">Demo Accounts</h3>
                            <div class="text-sm text-gray-600 space-y-2">
                                <div>
                                    <strong>Admin:</strong> admin@example.com / password
                                </div>
                                <div>
                                    <strong>Employee:</strong> employee@example.com / password
                                </div>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>