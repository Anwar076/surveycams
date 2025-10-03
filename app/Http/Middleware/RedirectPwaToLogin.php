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
        if ($isPwa && in_array($routeName, $hiddenInPwa)) {
            return redirect()->route('login', ['source' => 'pwa']);
        }

        // If PWA user accesses root path, redirect to login
        if ($isPwa && $request->is('/')) {
            return redirect()->route('login', ['source' => 'pwa']);
        }

        return $next($request);
    }

    /**
     * Check if request is from PWA
     */
    private function isPwaRequest(Request $request): bool
    {
        return $request->query('source') === 'pwa' || 
               ($request->header('User-Agent') && str_contains($request->header('User-Agent'), 'wv')) ||
               $request->header('X-PWABuilder-Rewrite') ||
               request()->headers->get('sec-fetch-dest') === 'empty' ||
               request()->headers->get('sec-fetch-mode') === 'navigate';
    }
}
