<?php

namespace App\Http\Middleware;

use App\User;
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
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if ($user->email_verified_at == null) {
                return abort(403, 'Akses ditolak. Email Anda belum terverifikasi');
            }
        }

        return $next($request);
    }
}
