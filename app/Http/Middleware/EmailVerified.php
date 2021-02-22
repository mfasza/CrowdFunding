<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        if ($user->email_verified_at != null && $user->password != null) {
            return $next($request);
        }

        return abort(403, 'Akses ditolak. Email Anda belum terverifikasi');
    }
}
