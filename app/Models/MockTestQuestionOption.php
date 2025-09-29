<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MockTestQuestionOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden=['correct_answer_index'];
    protected $casts = [
        'values' => 'array',
    ];

    public function question()
    {
        return $this->belongsTo(MockTestQuestion::class, 'question_id');
    }
}
