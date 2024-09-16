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
        Schema::create('dropboxes', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code')->unique();
            $table->string('title');
            $table->unsignedBigInteger('user_id');
            $table->string('file_path');
            $table->text('comment')->nullable();
            $table->enum('status', ['pending','for revision', 'approved', 'declined'])
            ->default('pending');
            $table->timestamps();          
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dropboxes');
    }
};
