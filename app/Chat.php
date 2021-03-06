<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\uuidPrimary;

class Chat extends Model
{
    use uuidPrimary;

    protected $fillable = ['subject', 'user_id', 'channel'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
