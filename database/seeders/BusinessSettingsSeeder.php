<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_settings')->updateOrInsert(
            ['id' => 1], // Assuming you want to update the record with ID 1
            [
                // Basic Info
                'business_name' => 'Mock Test',
                'business_email' => 'xyz@mocktest.com',
                'business_phone' => '1234567890',
                'bkash_number' => '01778899955',
                'certificate_amount' => '510.00',
                'website_url' => 'https://www.yourwebsite.com',
                'address' => 'BNS Center, Uttara, Dhaka',
    
                // Legal Info
                'bin_number' => '1234567890',
                'tin_number' => '9876543210',
                'trade_license' => 'TL-12345',
                'legal_docs' => 'Path/To/LegalDocs.pdf',
                'certification_docs' => 'Path/To/CertificationDocs.pdf',
                'authorized_docs' => 'Path/To/AuthorizedDocs.pdf',
    
                // Branding
                'logo' => 'Path/To/Logo.png',
                'favicon_icon' => 'Path/To/Favicon.ico',
    
                // Policies
                'privacy_policy' => 'Privacy Policy content goes here...',
                'terms_and_conditions' => 'Terms and conditions content goes here...',
                'return_policy' => 'Return policy content goes here...',
    
                // Social Media Links
                'facebook_url' => 'https://www.facebook.com/yourbusiness',
                'twitter_url' => 'https://www.twitter.com/yourbusiness',
                'linkedin_url' => 'https://www.linkedin.com/company/yourbusiness',
                'youtube_url' => 'https://www.youtube.com/c/yourbusiness',
                'instagram_url' => 'https://www.instagram.com/yourbusiness',

                'updated_by' => Auth::id(),
            ]
        );
    }
}
