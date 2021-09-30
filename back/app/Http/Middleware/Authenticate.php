<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Crypt;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    public function handle($request, \Closure $next, ...$guards)
    {
        if ($request->cookie('user')) {
            $decrypt = Crypt::decryptString($request->cookie('user'));
            $decrypt = json_decode($decrypt);
            $request->headers->set('Authorization', 'Bearer ' . $decrypt->token);

        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}
