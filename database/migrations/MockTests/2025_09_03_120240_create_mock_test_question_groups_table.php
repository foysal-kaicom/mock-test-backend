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
        Schema::create('mock_test_question_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mock_test_section_id')->constrained('mock_test_sections')->onDelete('cascade');
            $table->enum('type', ['single', 'multiple']);
            $table->enum('group_type', ['passage', 'audio'])->nullable();
            $table->text('content')->nullable()->comment('It can be passage or audio file path.');
            $table->integer('question_quantity')->default(1);
            $table->enum('status', ['active', 'disabled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mock_test_question_groups');
    }
};
