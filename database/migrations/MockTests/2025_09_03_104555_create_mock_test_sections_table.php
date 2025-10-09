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
        Schema::create('mock_test_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_test_module_id')->constrained('mock_test_modules')->onDelete('cascade');
            // $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('sample_question')->nullable();
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->integer('question_limit')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_test_sections');
    }
};
