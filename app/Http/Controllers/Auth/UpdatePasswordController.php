<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\User;

use function PHPSTORM_META\map;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdatePasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $user->update([
            'password' => bcrypt($request->password)
        ]);

        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Password berhasil diubah',
            'response_data' => $data
        ]);
    }
}
