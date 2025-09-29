<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->string('receiver_number');
            $table->decimal('amount', 15, 2);
            $table->decimal('received_amount', 15, 2)->nullable();
            $table->string('reference_number')->nullable();
            $table->string('sender_number')->nullable();
            $table->string('trx_number')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected', 'failed'])->default('pending'); // Enum for status
            $table->enum('delivery_status', ['pending', 'delivered'])->default('pending'); // Enum for certicate delivered or not
            $table->string('delivery_note')->nullable();
            $table->enum('claimed_format', ['hard-copy', 'soft-copy', 'both'])->default('soft-copy'); // Enum for claim type
            $table->datetime('delivery_date')->nullable();
            $table->string('confirmed_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificate_payments');
    }
}
