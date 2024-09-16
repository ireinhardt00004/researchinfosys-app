<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatFavoritesTable extends Migration
{
    public function up()
    {
        Schema::create('chat_favorites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id'); // Assuming this is correct
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('chat_id')->references('id')->on('chats')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->unique(['chat_id', 'user_id']); // Ensure a user can't favorite the same chat more than once
        });
    }

    public function down()
    {
        Schema::dropIfExists('chat_favorites');
    }
}
