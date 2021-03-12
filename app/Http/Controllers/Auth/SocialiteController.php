<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            'url' => $url
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }

    public function handleProviderCallback($provider)
    {
        try {
            $social_user = Socialite::driver($provider)->stateless()->user();

            if (!$social_user) {
                return response()->json([
                    'response_code' => '00',
                    'response_message' => "Gagal login."
                ], 401);
            }

            $user = User::whereEmail($social_user->email)->first();
            
            if (!$user) {
                if ($provider == 'google') {
                    $photo_profile = $social_user->avatar;
                }

                $now = Carbon::now();

                $user = User::create([
                    'email' => $social_user->email,
                    'name' => $social_user->name,
                    'photo' => $photo_profile,
                    'email_verified_at' => $now
                ]);

                $user->otp_codes->delete();
            }

            $data['user'] = $user;
            $data['token'] = auth()->login($user);

            return response()->json([
                'response_code' => '00',
                'response_message' => 'Berhasil login.',
                'response_data' => $data
            ], 200, [], JSON_UNESCAPED_SLASHES);

        } catch (\Throwable $th) {
            return response()->json([
                'response_code' => '01',
                'response_message' => 'Login failed.',
            ], 401);
        }
    }
}
