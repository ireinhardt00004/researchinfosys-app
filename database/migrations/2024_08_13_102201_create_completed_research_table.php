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
        Schema::create('completed_research', function (Blueprint $table) {
            $table->id();
           $table->string('title_research_program');
           $table->string('title_research_project')->nullable();
           $table->string('project_leader_staff')->nullable();
           $table->string('campus_college')->nullable();
           $table->string('date_started')->nullable();
           $table->string('date_completed')->nullable();
           $table->string('funding_cvsu')->nullable();
           $table->string('funding_external')->nullable();
           $table->string('ifnt_cvsu_research_type')->nullable();
           $table->string('cooperating_agency')->nullable();
           $table->string('thematic_area')->nullable();
           $table->string('fund_amount')->nullable();
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
        Schema::dropIfExists('completed_research');
    }
};
