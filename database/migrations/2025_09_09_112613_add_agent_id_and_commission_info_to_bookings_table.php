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
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('cascade');
            $table->decimal('commission_percentage', 5, 2)->nullable();
            $table->decimal('commission_amount', 10, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['agent_id', 'commission_percentage', 'commission_amount']);
        });
    }
};
