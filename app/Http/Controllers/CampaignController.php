<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignStoreRequest;
use App\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    
    public function random($count)
    {
        $campaigns = Campaign::getRandomCampaigns($count);
        
        $data['campaigns'] = $campaigns;

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Data campaign berhasil ditampilkan',
            'response_data' => $data
        ], 200);

    }

    public function store(CampaignStoreRequest $request)
    {
        $campaign = Campaign::create([
            'title' => $request->title,
            'description' => $request->description
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_extension = $image->getClientOriginalExtension();
            $image_name = $campaign->campaign_id . '.' . $image_extension;
            $image_folder = '/photos/campaign/';
            $image_location = $image_folder . $image_name;

            try {
                $image->move(public_path($image_folder), $image_name);

                $campaign->update([
                    'image' => $image_location
                ]);

                $data['campaign'] = $campaign;
            } catch (\Exception $e) {
                return response()->json([
                    'response_code' => '01',
                    'response_message' => 'Gambar gagal diunggah',
                    'response_data' => $data
                ], 200);
            }

        }

        $data['campaign'] = $campaign;

        return response()->json([
            'response_code' => '01',
            'response_message' => 'Data campaign berhasil ditambahakan',
            'response_data' => $data
        ], 200);

    }

}
