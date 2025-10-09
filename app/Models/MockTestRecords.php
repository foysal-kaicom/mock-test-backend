<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MockTestRecords extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'exam_id',
        'question_set',
        'total_marks',
    ];

    public function details()
    {
        return $this->hasMany(MockTestRecordDetails::class, 'mock_test_record_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
