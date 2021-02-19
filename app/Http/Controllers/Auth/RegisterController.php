<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\User;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt(123456)
        ]);

        $user->otp_codes()->create([
            'otp_code' => rand(100000, 999999),
            'valid_until' => now()->addMinutes(5)
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silakan cek email',
            'response_data' => $user
        ]);
    }
}
