<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCertificateClaimRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'booking_id' => 'sometimes|exists:bookings,id',
            'received_amount' => 'nullable|numeric',
            'reference_number' => 'nullable|string|max:255',
            'sender_number' => 'nullable|string|max:255',
            'trx_number' => ['nullable','string','max:255', Rule::unique('certificate_claims', 'trx_number')->ignore($this->route('id'))],
            'status' => 'in:pending,confirmed,rejected,failed',
            'delivery_status' => 'in:pending,delivered',
            'delivery_date' => 'nullable|date',
            'delivery_note' => 'nullable',
            'confirmed_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string|max:1000',
        ];
    }
}
