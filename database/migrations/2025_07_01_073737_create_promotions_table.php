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
        // promotion_templates
        Schema::create('promotion_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['email', 'sms']);
            $table->string('subject')->nullable(); // only for email
            $table->text('body');
            $table->timestamps();
        });

        // promotion_groups
        Schema::create('promotion_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // promotion_group_candidates
        Schema::create('promotion_group_candidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('promotion_groups')->onDelete('cascade');
            $table->foreignId('candidate_id')->constrained('candidates')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['group_id', 'candidate_id']); // avoid duplicates
        });

        // promotions
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('group_id')->nullable()->constrained('promotion_groups')->onDelete('cascade');
            $table->foreignId('template_id')->constrained('promotion_templates')->onDelete('cascade');
            $table->enum('send_to', ['targets', 'groups'])->default('groups'); // 'all' or selected groups
            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', ['draft', 'scheduled', 'sent','now'])->default('draft');
            $table->timestamps();
        });


        // promotion_targets (manually send to custom email or phone)
        Schema::create('promotion_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            // $table->enum('channel', ['email', 'sms']); //comes from template table
            $table->string('target'); // email or phone number
            $table->timestamps();
        });

        // promotion_logs (send logs) only failed cases
        Schema::create('promotion_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained('promotions')->onDelete('cascade');
            $table->foreignId('candidate_id')->nullable()->constrained('candidates')->onDelete('cascade');

            $table->enum('channel', ['email', 'sms']); 
            $table->enum('status', ['pending', 'sent', 'failed', 'bounced'])->default('pending')->index();

            $table->string('target')->nullable(); 
            $table->timestamp('sent_at')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promotion_logs');
        Schema::dropIfExists('promotion_targets');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('promotion_group_candidates');
        Schema::dropIfExists('promotion_groups');
        Schema::dropIfExists('promotion_templates');
    }

};
