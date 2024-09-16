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
        Schema::create('approved_manuscripts', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_code');
            $table->string('title');
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['dropbox', 'manuscript','N/A'])->default('N/A'); 
            $table->longText('author')->nullable();
            $table->unsignedBigInteger('coordinator_id')->nullable();
            $table->foreign('coordinator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_manuscripts');
    }
};
