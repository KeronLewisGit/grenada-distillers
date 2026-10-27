<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Visitors confirm they are of legal drinking age in Grenada (gdl.legal_age) before
 * they see the site. It is a plain redirect plus a cookie, so it works without JavaScript.
 */
class AgeGate
{
    public const string COOKIE = 'gdl_age_ok';

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->cookie(self::COOKIE) === '1' || ! $request->isMethodSafe()) {
            return $next($request);
        }

        $path = '/'.ltrim($request->getRequestUri(), '/');

        return redirect()->route('age.show', $path === '/' ? [] : ['next' => $path]);
    }

    /** Only a path on this site is a safe place to send someone back to. */
    public static function safeNext(mixed $next): string
    {
        $next = is_string($next) ? $next : '';

        // Control characters (tabs, line breaks) are refused too: browsers strip them, and a
        // line break in a Location header is a server error.
        return str_starts_with($next, '/') && ! str_starts_with($next, '//') && ! str_contains($next, '\\')
            && ! preg_match('/[\x00-\x20\x7f]/', $next) && ! str_starts_with($next, '/age') ? $next : '/';
    }
}
