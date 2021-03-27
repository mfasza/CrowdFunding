<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = Auth::attempt($credentials)) {
            $data['token'] = $token;
            $data['user'] = User::with(['roles'])->where('email', $request->email)->first();
            return response()->json([
                'response_code' => '00',
                'response_message' => 'User berhasil login',
                'response_data' => $data
            ]);
        }

        return response()->json(['error' => 'Kombinasi email dan password salah'], 401);
    }
}
