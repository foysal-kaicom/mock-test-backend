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
    Schema::create('blogs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('created_by')->constrained('users');

        $table->string('title');
        $table->string('slug')->unique();
        $table->longText('content');
        $table->text('tags')->nullable()->comment('store in json format');

        $table->string('featured_image')->nullable();

        $table->string('meta_title')->nullable();
        $table->text('meta_description')->nullable();
        $table->string('meta_keywords')->nullable();

        $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
        $table->boolean('is_featured')->default(false);
        $table->timestamp('published_at')->nullable();

        $table->timestamps();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
