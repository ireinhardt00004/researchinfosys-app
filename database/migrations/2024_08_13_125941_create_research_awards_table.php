<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('research_awards', function (Blueprint $table) {
            $table->id();
           $table->string('title_research_program');
           $table->string('title_research_project')->nullable();
           $table->string('project_leader_staff')->nullable();
           $table->string('campus_college')->nullable();
           $table->string('date_started')->nullable();
           $table->string('date_completed')->nullable();
           $table->string('research_title_award')->nullable();
           $table->string('researcg_title_output')->nullable();
           $table->string('researcher_award')->nullable();
           $table->string('date_awarded_researcher')->nullable();
           $table->string('venue')->nullable();
           $table->string('awarding_body')->nullable();
           $table->string('title_conference_symposium')->nullable();
           $table->string('level')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');                 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('research_awards');
    }
};
