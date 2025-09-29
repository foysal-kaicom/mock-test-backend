<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Modify as needed (if authorization logic is required)
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exam_id' => 'required|exists:exams,id',
            'center_id' => 'required|exists:centers,id',
            'status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'in:pending,success,failed,cancelled',
            'listening_score' => 'nullable|numeric',
            'reading_score' => 'nullable|numeric',
            'result_file' => 'nullable|file|mimes:pdf,docx,jpg,png|max:1024',  
            'admit_card_file' => 'nullable|file|mimes:pdf,docx,jpg,png|max:1024', 
            'certificate_file' => 'nullable|file|mimes:pdf,docx,jpg,png|max:1024',
            'booking_note' => 'nullable|string',
        ];
    }

}
