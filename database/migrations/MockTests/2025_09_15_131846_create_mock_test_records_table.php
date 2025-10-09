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
        Schema::create('mock_test_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->integer('question_set');
            // Reading module
            $table->integer('reading_answered')->default(0);
            $table->integer('correct_reading_answer')->default(0);
            $table->integer('wrong_reading_answer')->default(0);

            // Listening module
            $table->integer('listening_answered')->default(0);
            $table->integer('correct_listening_answer')->default(0);
            $table->integer('wrong_listening_answer')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_test_records');
    }
};
