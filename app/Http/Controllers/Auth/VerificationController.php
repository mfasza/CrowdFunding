<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Otp_codes;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $otp_code = Otp_codes::where('otp_code', $request->otp_code)->first();

        if (!$otp_code) {
            return response()->json([
                'response_code' => '01',
                'response_message' => "Kode OTP tidak ditemukan"
            ],200);
        }

        $now = Carbon::now();

        if ($now > $otp_code->valid_until) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Kode OTP sudah tidak berlaku, Silakan generate ulang'
            ],200);
        }

        // update user
        $user = User::find($otp_code->user_id);
        $user->email_verified_at = Carbon::now();
        $user->save();

        // delete otp
        $otp_code->delete();
        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Verifikasi kode OTP berhasil',
            'response_data' => $data
        ],200);
    }
}
