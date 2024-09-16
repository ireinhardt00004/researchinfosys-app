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
        Schema::create('publications', function (Blueprint $table) {
                $table->id();
                $table->string('title_research_program');
                $table->string('title_research_project')->nullable();
                $table->string('project_leader_staff')->nullable();
                $table->string('campus_college')->nullable();
                $table->string('date_started')->nullable();
                $table->string('date_completed')->nullable();
                $table->string('research_type')->nullable();
                $table->string('article_title')->nullable();
                $table->string('journal_name')->nullable();    
                $table->text('keywords')->nullable();                      
                $table->json('authors')->nullable();
                $table->string('volume_issue')->nullable();
                $table->string('date_publication')->nullable();
                $table->string('publication_type')->nullable();
                $table->string('issn_isbn')->nullable();
                $table->string('indexing_ched')->nullable();
                $table->string('remarks_pub')->nullable();  
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
        Schema::dropIfExists('publications');
    }
};
