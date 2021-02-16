<?php

namespace App;

use App\Traits\uuidPrimary;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use uuidPrimary;

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'role_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role'
    ];

    public function users()
    {
        return $this->hasMany("App\User", "role_id", "role_id");
    }
}
