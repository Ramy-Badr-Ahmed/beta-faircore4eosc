<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureNonPost
{
    private static array $postRoutes = ['/logout', '/password/email', '/email/verification-notification'];

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->getPathInfo(), self::$postRoutes) && !$request->isMethod('post') ) {

            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
