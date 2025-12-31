<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Protection (Legacy)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // STRICT HTTPS (HSTS) - Enable ONLY if site is on HTTPS
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        return $response;
    }
}
