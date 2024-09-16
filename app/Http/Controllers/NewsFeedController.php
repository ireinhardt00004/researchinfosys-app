<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\ActivityLog;

class NewsFeedController extends Controller
{
    //
    public function index() {
        $announcements = Announcement::orderBy('id', 'desc')->get();
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Announcement List page.'
        ]);
        return view('news.index', compact('announcements'));
    }
}
