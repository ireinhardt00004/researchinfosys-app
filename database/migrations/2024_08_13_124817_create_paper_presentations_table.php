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
        Schema::create('paper_presentations', function (Blueprint $table) {
            $table->id();
            $table->string('title_paper_presentation')->nullable();
            $table->text('authors')->nullable();
            $table->string('keywords')->nullable();
            $table->string('title_conference_symposium')->nullable();
            $table->string('date')->nullable();
            $table->string('venue')->nullable();
            $table->string('organizer')->nullable();
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
        Schema::dropIfExists('paper_presentations');
    }
};
