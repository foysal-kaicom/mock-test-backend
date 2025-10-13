<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = ['name', 'price', 'short_description', 'description','status', 'is_popular', 'is_home', 'is_free', 'order'];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_home' => 'boolean',
        'is_free' => 'boolean',
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
