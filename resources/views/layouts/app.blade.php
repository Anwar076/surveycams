<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- PWA Service Worker Registration -->
    <script>
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

        // Function to show install instructions
        function showInstallInstructions() {
            const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
            const isAndroid = /Android/.test(navigator.userAgent);

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
            e.preventDefault();
            deferredPrompt = e;
            if (installButton) {
                installButton.style.display = 'block';
            }
            if (installButtonMobile) {
                installButtonMobile.style.display = 'block';
            }
        });

        function handleInstall() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    console.log(`User response to the install prompt: ${choiceResult.outcome}`);
                    deferredPrompt = null;
                    if (installButton) {
                        installButton.style.display = 'none';
                    }
                    if (installButtonMobile) {
                        installButtonMobile.style.display = 'none';
                    }
                });
            } else {
                showInstallInstructions();
            }
        }

        if (installButton) {
            installButton.addEventListener('click', handleInstall);
        }
        if (installButtonMobile) {
            installButtonMobile.addEventListener('click', handleInstall);
        }

        window.addEventListener('appinstalled', () => {
            console.log('PWA was installed');
            if (installButton) {
                installButton.style.display = 'none';
            }
            if (installButtonMobile) {
                installButtonMobile.style.display = 'none';
            }
        });
    </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
