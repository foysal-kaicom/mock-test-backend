<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $fillable = ['candidate_id', 'package_id', 'tran_id', 'status', 'payment_status', 'total_payable','updated_by', 'title'];

    const FAILED='failed';
    const CANCELLED='cancelled';
    const CONFIRMED='confirmed';
    const SUCCESS='success';


    // Casts for certain fields (optional)
    protected $casts = [
        'total_payable' => 'double',
    ];
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }
    
    public function detail()
    {
        return $this->belongsTo(PackageDetail::class, 'package_details_id');
    }
}
