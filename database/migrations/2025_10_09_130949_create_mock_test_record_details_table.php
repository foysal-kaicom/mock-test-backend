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
        Schema::create('mock_test_record_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_test_record_id')->constrained('mock_test_records')->cascadeOnDelete();
            $table->foreignId('mock_test_question_id')->constrained('mock_test_questions')->cascadeOnDelete();
            $table->foreignId('mock_test_question_option_id')->nullable()->constrained('mock_test_question_options')->nullOnDelete();
            $table->foreignId('mock_test_section_id')->nullable()->constrained('mock_test_sections')->nullOnDelete();
            $table->foreignId('mock_test_module_id')->nullable()->constrained('mock_test_modules')->nullOnDelete();
            $table->boolean('is_correct')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_test_record_details');
    }
};
