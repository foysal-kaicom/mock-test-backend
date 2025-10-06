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
        'reading_answered',
        'correct_reading_answer',
        'wrong_reading_answer',
        'listening_answered',
        'correct_listening_answer',
        'wrong_listening_answer',
    ];

    public function candidate() {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    public function exam() {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}