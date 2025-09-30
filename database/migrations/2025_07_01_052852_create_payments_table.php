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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('booking_id')->nullable()->constrained('bookings');
            $table->foreignId('subscription_id')->nullable()->constrained('user_subscriptions')->nullOnDelete();

            $table->enum('type', ['booking', 'certificate'])->default('booking');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->string('reference')->nullable(); // trx ID
            $table->text('additionals')->nullable()->comment('all details of each payment request');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
