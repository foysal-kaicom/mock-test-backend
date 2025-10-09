<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessSetting extends Model
{
    protected $table = 'business_settings';

    protected $fillable = [
        'business_name',
        'business_email',
        'business_phone',
        'website_url',
        'address',
        'bin_number',
        'tin_number',
        'trade_license',
        'legal_docs',
        'certification_docs',
        'authorized_docs',
        'logo',
        'favicon_icon',
        'privacy_policy',
        'terms_and_conditions',
        'return_policy',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'instagram_url',
        'updated_by',
    ];

    protected $casts = [
        'legal_docs' => 'json',
    ];
}
