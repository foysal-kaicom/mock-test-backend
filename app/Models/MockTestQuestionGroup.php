<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MockTestQuestionGroup extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function mockTestQuestion()
    {
        return $this->hasMany(MockTestQuestion::class, 'mock_test_question_group_id');
    }
}
