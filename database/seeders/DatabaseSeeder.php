<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(FirstUserSeeder::class);
        $this->call(BusinessSettingsSeeder::class);
        $this->call(CandidateSeeder::class);
        $this->call(CenterSeeder::class);
        $this->call(ExamSeeder::class);
        $this->call(MockTestModuleSeeder::class);
        $this->call(MockTestSectionSeeder::class);
    }
}
