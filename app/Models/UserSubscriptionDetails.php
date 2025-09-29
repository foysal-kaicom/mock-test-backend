<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSubscriptionDetails extends Model
{
     use HasFactory;

    protected $fillable = [
        'user_subscription_id',
        'package_details_id',
        'exam_id',
        'max_exam_attempt',
    ];

    public function userSubscription()
    {
        return $this->belongsTo(UserSubscription::class);
    }

    public function packageDetail()
    {
        return $this->belongsTo(PackageDetail::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
