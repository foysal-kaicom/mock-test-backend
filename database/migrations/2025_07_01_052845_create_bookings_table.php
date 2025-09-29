<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates');
            $table->foreignId('exam_id')->constrained('exams');
            $table->foreignId('center_id')->constrained('centers');
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending'); //dropdown in edit

            $table->enum('payment_status', ['pending', 'success', 'failed','cancelled'])->default('pending');  //dropdown in edit
            $table->double('total_payable',10,2)->default(0.0); //not editable
           
            $table->string('result_file')->nullable();
            $table->string('result')->nullable()->comment('score'); //
            $table->string('admit_card_file')->nullable();
            
            $table->string('certificate_file')->nullable();
            $table->boolean('is_certificate_claimed')->default(false); //not needed in edit
            $table->timestamp('certificate_claimed_at')->nullable();

            $table->text('booking_note')->nullable(); //textarea
            $table->foreignId('updated_by')->nullable();

            $table->softDeletes();
            $table->timestamps();
           

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
