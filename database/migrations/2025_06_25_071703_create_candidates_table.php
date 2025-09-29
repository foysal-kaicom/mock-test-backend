<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->nullable(); // Mr./Mrs./Ms.
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();

            $table->string('email')->unique();
            $table->string('password');

            $table->date('date_of_birth')->nullable();
            $table->string('phone_number');
            $table->string('nationality')->nullable();
            $table->string('national_id')->nullable();

            $table->enum('gender', ['male', 'female']);
            $table->text('photo')->nullable(); // path to uploaded image
            $table->string('social_facebook')->nullable(); // path to uploaded image
            $table->string('social_linkedin')->nullable(); // path to uploaded image

            $table->boolean('is_email_verified')->default(true);
            $table->boolean('is_phone_verified')->default(false);
            $table->string('otp',6)->nullable();
            $table->dateTime('otp_expired_at')->nullable();
            $table->string('token',255)->nullable();
            $table->dateTime('token_expired_at')->nullable();
            $table->integer('otp_reset_attempts')->nullable();// number of attempts that we allow user to send OTP
            $table->enum('status',['active','frozen'])->default('active');

            $table->text('address')->nullable();
            $table->string('currently_living_country')->default('Bangladesh');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
