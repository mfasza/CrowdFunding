<?php

namespace App;

use App\Traits\uuidPrimary;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, uuidPrimary;

    /**
     * The "booting" function of model
     *
     * @return void
     */
    protected static function boot() {
        parent::boot();
        static::created(function ($model) {
            $model->generateOtpCode();
        });
    }

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'user_id';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'photo', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsTo("App\Roles", "role_id", 'role_id');
    }

    public function otp_codes()
    {
        return $this->hasOne("App\Otp_codes", "user_id", "user_id");
    }

    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_id', 'user_id');
    }

    public function isAdmin()
    {
        if ($this->role_id == Roles::where('role', 'admin')->first()->role_id) {
            return true;
        }
        return false;
    }

    public function generateOtpCode()
    {
        do {
            $otp_code = rand(100000, 999999);
            $check = Otp_codes::where('otp_code', $otp_code)->first();
        } while ($check);

        $now = Carbon::now();

        $otp = Otp_codes::updateOrCreate(
            ['user_id' => $this->user_id],
            ['otp_code' => $otp_code, 'valid_until' => $now->addMinutes(5)]
        );
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
