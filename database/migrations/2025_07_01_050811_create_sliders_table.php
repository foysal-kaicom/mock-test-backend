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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->boolean('is_button_enable')->default(false);
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->text('slider_text')->nullable();
            $table->boolean('status')->default(true);
            $table->integer('position')->default(0); 
            $table->softDeletes();
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
