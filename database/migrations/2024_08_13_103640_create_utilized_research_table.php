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
        Schema::create('utilized_research', function (Blueprint $table) {
        $table->id();
        $table->string('title_research_program');
        $table->string('title_research_project')->nullable();
        $table->string('project_leader_staff')->nullable();
        $table->string('campus_college')->nullable();
        $table->string('date_started')->nullable();
        $table->string('date_completed')->nullable();
        $table->string('ifnt_cvsu_research_type')->nullable();
        $table->string('beneficiary_industry')->nullable();
        $table->string('product_name_method')->nullable();
        $table->string('brief_desc')->nullable();
        $table->string('patent_utility')->nullable();
        $table->string('initial_date_utilization')->nullable();
        $table->string('development')->nullable();
        $table->string('service')->nullable();
        $table->string('utilization_others')->nullable();
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
        Schema::dropIfExists('utilized_research');
    }
};
