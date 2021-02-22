<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
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
        // create user
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);

        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Anda berhasil mendaftar. Silakan cek email untuk verifikasi kode OTP',
            'response_data' => $data
        ]);
    }
}
