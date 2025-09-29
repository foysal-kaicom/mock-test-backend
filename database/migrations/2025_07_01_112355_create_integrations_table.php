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
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
    
            $table->enum('type',['sms','smtp','payment_gateway','storage','google','facebook','other']); // smtp, payment_gateway, sms_gateway
            $table->string('name'); // e.g., Mailgun, Stripe, Twilio
            $table->string('slug')->unique(); // e.g., mailgun, stripe, twilio
    
            $table->boolean('is_active')->default(false);
            $table->json('credentials')->nullable()->comment('store API keys, secrets, etc.');
            $table->json('options')->nullable();   
    
            $table->text('description')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integrations');
    }
};
