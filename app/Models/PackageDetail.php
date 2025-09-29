<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageDetail extends Model
{
    protected $fillable = ['package_id', 'exam_id', 'max_exam_attempt'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
