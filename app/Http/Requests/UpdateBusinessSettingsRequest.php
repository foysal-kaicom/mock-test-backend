<?php

// app/Http/Requests/UpdateBusinessSettingsRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $route = $this->route()->getName();

        switch ($route) {
            case 'business-settings.general':
                return [
                    'business_name' => 'required|string|max:255',
                    'business_email' => 'required|email',
                    'business_phone' => 'required|string',
                    'website_url' => 'nullable|url',
                    'address' => 'nullable|string',
                    'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ];

            case 'business-settings.legal':
                return [
                    'tin_number' => 'nullable|string',
                    'bin_number' => 'nullable|string',
                    'trade_license' => 'nullable|string',
                    'certification_docs' => 'nullable|file|max:4096',
                    'authorized_docs' => 'nullable|file|max:4096',
                    'legal_docs.*' => 'nullable|file|max:4096',
                ];

            case 'business-settings.social':
                return [
                    'facebook_url' => 'nullable|url',
                    'twitter_url' => 'nullable|url',
                    'linkedin_url' => 'nullable|url',
                    'youtube_url' => 'nullable|url',
                    'instagram_url' => 'nullable|url',
                    'favicon_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                ];

            case 'business-settings.policies':
                return [
                    'privacy_policy' => 'nullable|string',
                    'terms_and_conditions' => 'nullable|string',
                    'return_policy' => 'nullable|string',
                ];

            default:
                return [];
        }
    }
}
