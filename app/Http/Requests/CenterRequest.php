<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CenterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'seat_capacity' => 'nullable|integer|min:1',
            'location' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:255',
            'status' => 'boolean',
        ];
    }
}
