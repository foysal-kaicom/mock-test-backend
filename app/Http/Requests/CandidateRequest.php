<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CandidateRequest extends FormRequest
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
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'first_name'        => 'required|string|max:100',
            'last_name'         => 'required|string|max:100',
            'date_of_birth'     => 'required|date|before_or_equal:' . now()->subYears(10)->toDateString(),
            'national_id'       => 'required|string|max:20',
            'gender'            => 'required|in:male,female',
            'currently_living_country'   => 'nullable|in:Bangladesh,Japan',
            'social_facebook'   => 'nullable|url',
            'social_linkedin'   => 'nullable|url',
            'address'           => 'nullable|string|max:500',
            'photo' => $isUpdate
                ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'] // optional during update
                : ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // required during create

            'email' => $isUpdate
                ? ['prohibited'] // completely block updating email
                : ['required', 'email', 'unique:candidates,email'],

           'phone_number' => $isUpdate
                ? ['prohibited'] // block updates
                : ['required', Rule::unique('candidates', 'phone_number')],
        ];
    }
}
