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
        Schema::table('mock_test_records', function (Blueprint $table) {
            $table->foreignId('exam_id')->nullable()->constrained('exams')->onDelete('cascade')->after('candidate_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mock_test_records', function (Blueprint $table) {
            //
        });
    }
};
