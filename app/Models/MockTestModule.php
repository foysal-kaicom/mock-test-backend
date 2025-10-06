<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MockTestModule extends Model
{
    use HasFactory;

    protected $fillable = ['exam_id', 'slug', 'name', 'status'];

    public function sections()
    {
        return $this->hasMany(MockTestSection::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
