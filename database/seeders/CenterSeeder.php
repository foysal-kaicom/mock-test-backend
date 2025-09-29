<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CenterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('centers')->insert([
            [
                'name' => 'Dhaka Exam Center',
                'seat_capacity' => 100,
                'location' => 'Dhaka',
                'address' => '123/A, Gulshan-1, Dhaka 1212',
                'image' => null,
                'contact_phone' => '01712345678',
                'contact_email' => 'dhaka.center@example.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chattogram Exam Center',
                'seat_capacity' => 80,
                'location' => 'Chattogram',
                'address' => '456/B, Agrabad, Chattogram 4100',
                'image' => null,
                'contact_phone' => '01876543210',
                'contact_email' => 'ctg.center@example.com',
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
