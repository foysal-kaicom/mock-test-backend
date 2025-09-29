<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ExamSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exams')->insert([
            [
                'title' => 'Japan Yunus Test',
                'slug' => Str::slug('General Knowledge Test'),
                'description' => 'This exam tests general knowledge skills including current affairs, history, and reasoning.',
                'exam_date' => '2025-08-10',
                'application_deadline' => '2025-08-01',
                'fee' => 500.00,
                'image' => null,
                'result_publish_date' => '2025-08-20',
                'status' => true,
                'start_time' => '10:00:00',
                'end_time' => '12:00:00',
                'created_by' => 1, // make sure user with ID 1 exists
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Arigana Proficiency Exam',
                'slug' => Str::slug('English Proficiency Exam'),
                'description' => 'Assessment of grammar, vocabulary, comprehension and writing skills.',
                'exam_date' => '2025-09-05',
                'application_deadline' => '2025-08-25',
                'fee' => 800.00,
                'image' => null,
                'result_publish_date' => '2025-09-15',
                'status' => true,
                'start_time' => '14:00:00',
                'end_time' => '16:00:00',
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
