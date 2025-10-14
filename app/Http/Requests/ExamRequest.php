<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // 'exam_date' => 'nullable|date',
            // 'application_deadline' => 'nullable|date',
            // 'result_publish_date' => 'nullable|date',
            // 'fee' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // 'start_time' => 'nullable|date_format:H:i',
            // 'end_time' => 'nullable|date_format:H:i',
        ];
    }
}
