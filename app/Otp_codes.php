<?php

namespace App;

use App\Traits\uuidPrimary;
use Illuminate\Database\Eloquent\Model;

class Otp_codes extends Model
{
    use uuidPrimary;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'otp_code_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'otp_code', 'kadaluarsa'
    ];

    public function users()
    {
        return $this->belongsTo("App\User", "user_id", "user_id");
    }
}
