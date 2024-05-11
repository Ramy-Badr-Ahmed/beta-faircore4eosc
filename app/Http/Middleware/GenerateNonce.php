<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GenerateNonce
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{
            $request->headers->add([
                'jsNonce' => bin2hex(random_bytes(8)),
                'cssNonce' => bin2hex(random_bytes(8))
            ]);

        }catch (Exception $e){
            return $next($request);
        }

        return $next($request);
    }
}
