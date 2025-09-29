<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MockTestSection;

class MockTestSectionSeeder extends Seeder
{
    public function run()
    {
        // First four sections belong to mock_test_module_id = 1
        MockTestSection::create([
            'mock_test_module_id' => 1,
            'slug' => 'photo-description',
            'title' => 'Photo description',
            'sample_question' => 'What is in the photo?\nA) A dog\nB) A cat\nC) A bird\nAnswer: A',
            'status' => 'active',
            'question_limit' => 10,
        ]);

        MockTestSection::create([
            'mock_test_module_id' => 1,
            'slug' => 'questions-and-answers',
            'title' => 'Questions and Answers',
            'sample_question' => 'What is the capital of France?\nA) Berlin\nB) Madrid\nC) Paris\nAnswer: C',
            'status' => 'active',
            'question_limit' => 9,

        ]);

        MockTestSection::create([
            'mock_test_module_id' => 1,
            'slug' => 'dialogue',
            'title' => 'Dialogue',
            'sample_question' => 'What did John say to Mary?\nA) Hello\nB) Goodbye\nC) See you later\nAnswer: A',
            'status' => 'active',
            'question_limit' => 13,

        ]);

        MockTestSection::create([
            'mock_test_module_id' => 1,
            'slug' => 'explanatory-text',
            'title' => 'Explanatory text',
            'sample_question' => 'Read the following passage and answer the question.\n"Paris is the capital of France. It is known for its iconic landmarks, like the Eiffel Tower."\nWhat is the capital of France?\nA) Paris\nB) London\nC) New York\nAnswer: A',
            'status' => 'active',
            'question_limit' => 8,

        ]);

        // Second four sections belong to mock_test_module_id = 2
        MockTestSection::create([
            'mock_test_module_id' => 2,
            'slug' => 'choose-correct-answer',
            'title' => 'Choose correct answer',
            'sample_question' => 'What is 2 + 2?\nA) 3\nB) 4\nC) 5\nAnswer: B',
            'status' => 'active',
            'question_limit' => 6,

        ]);

        MockTestSection::create([
            'mock_test_module_id' => 2,
            'slug' => 'correct-wrong-sentences',
            'title' => 'Correct wrong sentences',
            'sample_question' => 'Choose the correct sentence:\nA) He don\'t like ice cream.\nB) He doesn\'t like ice cream.\nAnswer: B',
            'status' => 'active',
            'question_limit' => 11,

        ]);

        MockTestSection::create([
            'mock_test_module_id' => 2,
            'slug' => 'fill-in-the-blanks',
            'title' => 'Fill in the blanks',
            'sample_question' => 'Fill in the blank: The sun rises in the _____.\nA) west\nB) east\nC) north\nAnswer: B',
            'status' => 'active',
            'question_limit' => 13,

        ]);

        MockTestSection::create([
            'mock_test_module_id' => 2,
            'slug' => 'reading-comprehension',
            'title' => 'Reading comprehension',
            'sample_question' => 'Read the passage: "The sun is a star. It provides light and warmth to the Earth." What does the sun do?\nA) It is a planet\nB) It provides light and warmth\nC) It is cold\nAnswer: B',
            'status' => 'active',
            'question_limit' => 10,

        ]);
    }
}
