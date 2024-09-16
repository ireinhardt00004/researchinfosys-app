<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ChatController extends Controller
{
    //
    public function index() {
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited the Chat page.'
        ]);
        return view('chats.index');
    }
}
