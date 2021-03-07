<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\uuidPrimary;

class Blog extends Model
{
    use uuidPrimary;

    public function getKeyName()
    {
        return 'blog_id';
    }

    protected $fillable = [
        'title', 'description', 'image'
    ];

    public static function getRandomBlogs(Int $count)
    {
        $campaigns = Blog::select('*')
                    ->inRandomOrder()
                    ->limit($count)
                    ->get();

        return $campaigns;
    }
}
