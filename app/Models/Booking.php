<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    protected $fillable = [
        'candidate_id',
        'exam_id',
        'center_id',
        'agent_id',
        'status',
        'payment_status',
        'total_payable',
        'result_file',
        'result',
        'admit_card_file',
        'certificate_file',
        'is_certificate_claimed',
        'certificate_claimed_at',
        'booking_note',
        'updated_by',
        'listening_score',
        'commission_percentage',
        'commission_amount',
        'reading_score',
        'country_code',
        'center_code',
        'examinee_number'
    ];

    const FAILED='failed';
    const CANCELLED='cancelled';
    const CONFIRMED='confirmed';
    const SUCCESS='success';


    // Casts for certain fields (optional)
    protected $casts = [
        'total_payable' => 'double',
        'is_certificate_claimed' => 'boolean',
        'certificate_claimed_at' => 'datetime',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id', 'id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id', 'id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class, 'center_id', 'id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id')->where('type','booking');
    }

    public function certificate_payment()
    {
        return $this->hasOne(CertificateClaim::class, 'booking_id', 'id');
    }

    public function agent()
    {
        return $this->belongsTo(Center::class, 'agent_id', 'id');
    }
}
