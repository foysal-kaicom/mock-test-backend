<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'price', 'short_description', 'description','status', 'is_popular'];

    protected $casts = [
        'is_popular' => 'boolean',
    ];

    public function package_details()
    {
        return $this->hasMany(PackageDetail::class);
    }

    // public function subscriptions()
    // {
    //     return $this->hasMany(UserSubscription::class);
    // }
}
