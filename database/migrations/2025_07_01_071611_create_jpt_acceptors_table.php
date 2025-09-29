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
        Schema::create('jpt_acceptors', function (Blueprint $table) {
            $table->id();
    
            $table->string('institute_name');
            $table->string('institute_type')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            
            $table->text('description')->nullable()->comment('story -when and how jpt get accreditation from this institute');
            $table->text('address')->nullable();
            $table->string('website')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
    
            $table->text('note')->nullable(); 
            $table->boolean('status')->default(true);
            $table->text('accreditation_certificate')->nullable()->comment('that can be image or pdf');

    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jpt_acceptors');
    }
};
