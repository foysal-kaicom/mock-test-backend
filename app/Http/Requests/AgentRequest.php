<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => 'required|string|max:255',
            'business_name' => 'required|string|max:255',
            'email' => $isUpdate
                ? ['prohibited']
                : ['required', 'email', 'unique:agents,email'],
            'phone' => 'required|string|max:15',
            'location' => 'required|string|max:255',
            'commission_percentage' => 'required|numeric|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Agent name is required.',
            'business_name.required' => 'Agency name is required.',
            'email.required' => 'Email is required.',
            'phone.required' => 'Phone number is required.',
            'location.required' => 'Location is required.',
            'photo.image' => 'Photo must be an image.',
        ];
    }
}
