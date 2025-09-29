<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Candidate extends Authenticatable implements JWTSubject
{
    use HasFactory, SoftDeletes, Notifiable;

    protected $guarded=[];

    // protected $fillable = [
    //     'prefix',
    //     'first_name',
    //     'last_name',
    //     'surname',
    //     'email',
    //     'password',
    //     'date_of_birth',
    //     'phone_number',
    //     'nationality',
    //     'national_id',
    //     'gender',
    //     'photo',
    //     'address',
    //     'status',
    //     'otp',
    //     'otp_expired_at',
    //     'is_phone_verified'
    // ];

    protected $hidden = [
        'password','otp'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return []; 
    }

    public function getFullNameAttribute() 
    {
        return $this->first_name.' '. $this->last_name;  
    }


    public function bookings() 
    {
        return $this->hasMany(Booking::class,'candidate_id');
    }
}
