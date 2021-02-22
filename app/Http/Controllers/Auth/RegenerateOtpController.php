<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class RegenerateOtpController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Alamat email tidak ditemukan'
            ],200);
        }

        if ($user->email_verified_at != null) {
            return response()->json([
                'response_code' => '00',
                'response_message' => 'Alamat email sudah terverifikasi'
            ],200);
        }

        $user->generateOtpCode();

        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Kode OTP sudah diperbaruhi. Silakan cek email',
            'response_data' => $data
        ]);
    }
}
