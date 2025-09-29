<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamListFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'date_filter' => 'nullable|in:exam_date,application_deadline,result_publish_date',
            'from_date' => 'nullable|date|before_or_equal:to_date|required_with:date_filter',
            'to_date' => 'nullable|date|required_with:from_date|after_or_equal:from_date',
        ];
    }
}
