<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockTestQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(MockTestSection::class,'mock_test_section_id');
    }

    public function mockTestQuestionGroup()
    {
        return $this->belongsTo(MockTestQuestionGroup::class,'mock_test_question_group_id');
    }

    public function mockTestQuestionOption()
    {
        return $this->hasOne(MockTestQuestionOption::class, 'mock_test_question_id');
    }
}
