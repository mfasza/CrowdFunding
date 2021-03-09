<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\uuidPrimary;

class Campaign extends Model
{
    use uuidPrimary;

    public function getKeyName()
    {
        return 'campaign_id';
    }

    protected $fillable = [
        'title', 'description', 'image'
    ];

    public static function getRandomCampaigns(Int $count)
    {
        $campaigns = Campaign::select('*')
                    ->inRandomOrder()
                    ->limit($count)
                    ->get();

        return $campaigns;
    }

    public static function searchCampaign($keyword)
    {
        $campaigns = Campaign::select('*')
                    ->where('title', 'LIKE', '%'.$keyword.'%')
                    ->get();
                
        return $campaigns;
    }
}
