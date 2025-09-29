<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CandidateSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('candidates')->insert([
            [
                'prefix' => 'Mr.',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'surname' => 'Smith',
                'email' => 'john.doe@example.com',
                'password' => Hash::make('password123'),
                'date_of_birth' => '1990-05-15',
                'phone_number' => '01700000000',
                'nationality' => 'Bangladeshi',
                'national_id' => '1234567890',
                'gender' => 'Male',
                'photo' => null,
                'social_facebook' => 'https://facebook.com/johndoe',
                'social_linkedin' => 'https://linkedin.com/in/johndoe',
                'is_email_verified' => true,
                'is_phone_verified' => true,
                'otp' => null,
                'otp_expired_at' => null,
                'otp_reset_attempts' => 0,
                'status' => 'active',
                'address' => '123, Gulshan, Dhaka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more dummy users here if needed
        ]);
    }
}
