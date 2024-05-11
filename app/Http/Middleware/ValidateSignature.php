<?php

namespace App\Http\Middleware;


use Illuminate\Http\Response;
use Illuminate\Routing\Middleware\ValidateSignature as Middleware;
use Closure;

class ValidateSignature extends Middleware
{
    /**
     * The names of the query string parameters that should be ignored.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];

#______________________________________________________________________________________________________________________________________________________________________________________________
    /**
     * @param $request
     * @param Closure $next
     * @param ...$args
     * @return Response
     */

    public function handle($request, Closure $next, ...$args)
    {
        if(config('app.enforce_https')){
            $request->server->set('HTTPS', true);
        }

        return parent::handle($request, $next, ...$args);
    }
}
