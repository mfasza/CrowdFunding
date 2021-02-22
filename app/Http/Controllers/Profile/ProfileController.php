<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data['profile'] = auth()->user();
        return response()->json([
            'response_code' => '00',
            'response_message' => "Profile berhasil ditampilkan",
            'response_data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['string'],
            'photo' => ['bail', 'image', 'mimes:png,jpg']
        ], [
            'required' => "Gambar belum dipilih",
            'image' => "File yang dipilih bukan gambar",
            'mimes' => "Ekstensi yang diperbolehkan hanya .png & .jpg"
        ])->validate();

        $user = auth()->user();

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');

            $dir = public_path('/photos/users/profile-photo/');
            $photo_name = Str::slug($request->name, "-") . '-' . $user->user_id . "." . $photo->getClientOriginalExtension();
            $photo->move($dir, $photo_name);

            $user->update([
                'photo' => '/photos/users/profile-photo/'.$photo_name
            ]);
        }

        $user->update([
            'name' => $request->name
        ]);

        $data['user'] = $user;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Profil berhasil diperbaruhi',
            'response_data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
