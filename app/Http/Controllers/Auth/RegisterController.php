<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Otp_codes;
use App\User;
use Carbon\Carbon;

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
            'email' => $request->get('email'),
            'password' => bcrypt(123456)
        ]);

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

        // create otp_code
        $user->otp_codes()->create([
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
