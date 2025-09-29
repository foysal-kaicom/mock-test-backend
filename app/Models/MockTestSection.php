<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockTestSection extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function mockTestQuestionGroup()
    {
        return $this->hasMany(MockTestQuestionGroup::class,'mock_test_section_id');
    }
    public function mockTestModule()
    {
        return $this->belongsTo(MockTestModule::class,'mock_test_module_id');
    }

    public function mockTestQuestion()
    {
        return $this->hasMany(MockTestQuestion::class);
    }
}
