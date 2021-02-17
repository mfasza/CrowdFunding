<?php

namespace App\Http\Middleware;

use Closure;

class EmailVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->email_verified_at != null) {
            return $next($request);
        }
        return abort(403, 'Email Anda belum terverifikasi');
    }
}
