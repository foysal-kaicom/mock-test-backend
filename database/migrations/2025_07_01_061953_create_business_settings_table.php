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
        Schema::create('business_settings', function (Blueprint $table) {
            $table->id();
    
            // Basic Info
            $table->string('business_name');
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('bkash_number')->nullable();
            $table->string('website_url')->nullable();
            $table->string('certificate_amount')->nullable();
            $table->text('address')->nullable();
    
            // Legal Info
            $table->string('bin_number')->nullable(); 
            $table->string('tin_number')->nullable();  
            $table->string('trade_license')->nullable();
            $table->text('legal_docs')->nullable(); 
            $table->string('certification_docs')->nullable(); 
            $table->string('authorized_docs')->nullable();
    
            // Branding
            $table->string('logo')->nullable();
            $table->string('favicon_icon')->nullable();
    
            // Policies
            $table->longText('privacy_policy')->nullable();
            $table->longText('terms_and_conditions')->nullable();
            $table->longText('return_policy')->nullable();
    
            // Social Media Links
            $table->string('facebook_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('instagram_url')->nullable();

            $table->foreignId('updated_by')->nullable();
    
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_settings');
    }
};
