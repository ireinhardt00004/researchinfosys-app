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
        Schema::create('invention_utilities', function (Blueprint $table) {
            $table->id();
           $table->string('title_research_program');
           $table->string('title_research_project')->nullable();
           $table->string('project_leader_staff')->nullable();
           $table->string('campus_college')->nullable();
           $table->string('date_started')->nullable();
           $table->string('date_completed')->nullable();
           $table->string('ifnt_cvsu_research_type')->nullable();
           $table->string('title_invention_utility_model')->nullable();
           $table->string('patent_number')->nullable();
           $table->string('date_of_issue')->nullable();
           $table->string('utilization_invention_development')->nullable();
           $table->string('utilization_invention_service')->nullable();
           $table->string('name_commercial_product')->nullable();
           $table->string('points')->nullable();
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
        Schema::dropIfExists('invention_utilities');
    }
};
