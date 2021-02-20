<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ], [
            'email.required' => 'Email belum diisi',
            'password.required' => 'Password belum diisi',
            'email' => 'Alamat email tidak valid',
            'exists' => 'Alamat email tidak ditemukan'
        ])->validate();

        $credentials = $request->only('email', 'password');

        if ($token = Auth::attempt($credentials)) {
            $data['token'] = $token;
            $data['user'] = User::where('email', $request->email)->first();
            return response()->json([
                'response_code' => '00',
                'response_message' => 'User berhasil login',
                'response_data' => $data
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
