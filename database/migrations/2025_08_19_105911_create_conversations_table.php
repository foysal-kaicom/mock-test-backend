<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidates')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->boolean('is_seen')->default(false);
            $table->dateTime('read_at')->nullable();
            $table->text('attachment')->nullable(); 
            $table->timestamps();

            $table->index(['candidate_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('conversations');
    }
};