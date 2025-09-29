<?php

namespace Database\Seeders;

use App\Models\MockTestModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MockTestModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        MockTestModule::create([
            'slug' => 'listening',
            'name' => 'Listening',
            'status' => 'active',
        ]);

        MockTestModule::create([
            'slug' => 'reading',
            'name' => 'Reading',
            'status' => 'active',
        ]);
    }
}
