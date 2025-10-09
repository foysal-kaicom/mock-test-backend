<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mock_test_questions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('It can be text or image path.');
            $table->enum('proficiency_level', ['N4', 'N5']);
            $table->foreignId('mock_test_section_id')->constrained('mock_test_sections')->onDelete('cascade');
            $table->foreignId('mock_test_question_group_id')->nullable()->constrained('mock_test_question_groups')->onDelete('cascade');
            $table->enum('type', ['text', 'image']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_test_questions');
    }
};
