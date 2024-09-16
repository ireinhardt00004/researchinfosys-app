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
        Schema::create('citations', function (Blueprint $table) {
            $table->id();
           $table->string('title_research_program')->nullable();
           $table->string('title_research_project')->nullable();
           $table->string('project_leader_staff')->nullable();
           $table->string('campus_college')->nullable();
           $table->string('date_started')->nullable();
           $table->string('date_completed')->nullable();
           $table->string('ifnt_cvsu_research_type')->nullable();
           $table->string('article_title')->nullable();
           $table->string('journal_name_book')->nullable();
           $table->string('authors')->nullable();
           $table->string('volume_no')->nullable();
           $table->string('date_publication')->nullable();
           $table->string('issn_isbn')->nullable();
           $table->string('indexing_ched')->nullable();
           $table->string('date_cited')->nullable();
           $table->string('author_who_cited')->nullable();
           $table->string('title_article_where_cited')->nullable();
           $table->string('title_journal')->nullable();
           $table->string('vol_issue_no')->nullable();
           $table->string('date_published')->nullable();
           $table->string('indexing_ched_that_cited')->nullable();
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
        Schema::dropIfExists('citations');
    }
};
