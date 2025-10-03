<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectPwaToLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isPwa = $this->isPwaRequest($request);
        $routeName = $request->route() ? $request->route()->getName() : null;

        // Only apply PWA logic if this middleware is explicitly applied
        // and the request is definitely from an installed PWA
        if ($isPwa) {
            // Marketing/public pages that should be hidden in PWA
            $hiddenInPwa = [
                'welcome',
                'features',
                'pricing',
                'about',
                'blog',
                'careers',
                'contact',
                'help',
                'documentation',
                'status',
                'security',
                'api',
                'integrations',
                'privacy',
                'terms',
            ];

            // If PWA user tries to access marketing pages, redirect to login
            if (in_array($routeName, $hiddenInPwa)) {
                return redirect()->route('login', ['source' => 'pwa']);
            }

            // If PWA user accesses root path, redirect to login
            if ($request->is('/')) {
                return redirect()->route('login', ['source' => 'pwa']);
            }
        }

        return $next($request);
    }

    /**
     * Check if request is from PWA (installed app)
     */
    private function isPwaRequest(Request $request): bool
    {
        // Only redirect if explicitly from PWA source
        // OR if in standalone display mode (installed PWA)
        return $request->query('source') === 'pwa' || 
               $request->header('X-PWABuilder-Rewrite') ||
               ($request->hasHeader('Sec-Fetch-Dest') && $request->header('Sec-Fetch-Dest') === 'empty');
    }
}
