<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MockTestRecordDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'mock_test_record_id',
        'mock_test_question_id',
        'mock_test_question_option_id',
        'mock_test_section_id',
        'mock_test_module_id',
        'is_correct',
    ];

    public function record()
    {
        return $this->belongsTo(MockTestRecords::class, 'mock_test_record_id');
    }

    public function question()
    {
        return $this->belongsTo(MockTestQuestion::class, 'mock_test_question_id');
    }

    public function questionOption()
    {
        return $this->belongsTo(MockTestQuestionOption::class, 'mock_test_question_option_id');
    }

    public function section()
    {
        return $this->belongsTo(MockTestSection::class, 'mock_test_section_id');
    }

    public function module()
    {
        return $this->belongsTo(MockTestModule::class, 'mock_test_module_id');
    }
}
