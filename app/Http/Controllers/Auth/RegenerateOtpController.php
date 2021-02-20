<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Otp_codes;
use App\User;
use Carbon\Carbon;
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

        // check uniqueness of otp codes
        $otp_code = rand(100000, 999999);
        while (true) {
            $otp_codes = Otp_codes::get('otp_code')->toArray();
            if (in_array($otp_code, $otp_codes)) {
                $otp_code = rand(100000, 999999);
            } else {
                break;
            }
        }

        $user->otp_codes()->update([
            'otp_code' => $otp_code,
            'valid_until' => Carbon::now()->addMinutes(5)
        ]);

        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Silakan cek email',
            'response_data' => $data
        ]);
    }
}
