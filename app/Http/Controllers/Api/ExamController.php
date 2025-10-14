<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExamResource;
use App\Models\Exam;

class ExamController extends Controller
{
    public function list()
    {
        $exams=Exam::where('status',1)
            ->orderBy('id' ,'desc')
            ->take(12)
            ->get();

        return $this->responseWithSuccess(ExamResource::collection($exams),'Exam List.');
    }

    public function view($slug)
    {
        $exam=Exam::where('slug', $slug)->first();

        return $this->responseWithSuccess($exam,'Single Exam View.');
    }

}
