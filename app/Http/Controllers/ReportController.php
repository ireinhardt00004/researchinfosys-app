<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\ContactUs;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement;
use App\Models\Manuscript;
use App\Models\Dropbox;

class ReportController extends Controller
{
    //
    public function adminKra() {

        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $userID = $user->id;
        $manuscripts = Manuscript::latest()->get();
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Visited Submitted Manuscript List page.',
        ]);
        return view('reports.admin-kra', compact('manuscripts'));
    }
    public function index() {

        $user = auth()->user();
         if ($user->roles !== 'sub-admin') {
            abort(403, 'Unauthorized');
         }
        $userID = $user->id;
        $manuscripts = Manuscript::where('coordinator_id',$userID)->get();
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Visited Submitted Manuscript List page.',
        ]);
        return view('reports.index', compact('manuscripts'));
    }
    public function adminIndex() {
        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $userID = $user->id;
        $manuscripts = Dropbox::latest()->get();
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Visited Coordinators Report page.',
        ]);
        return view('reports.admin-index', compact('manuscripts'));
    }

    public function adminManViewer() { 
        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Visited List of Researchers page.',
        ]);
        $manuscripts = Manuscript::latest()->get();
        return view ('admin.manuscript', compact('manuscripts'));

    }
}
