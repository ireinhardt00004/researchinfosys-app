<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatFavorite extends Model
{
    protected $fillable = ['chat_id', 'user_id'];

    // Define relationships if needed
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
