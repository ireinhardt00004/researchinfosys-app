<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use App\Models\Announcement;
use App\Models\Manuscript;
use App\Models\Dropbox;

class AdminController extends Controller
{
    public function index() {
        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
    
        // Get logout data
        $logoutData = DB::table('visits')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->select(DB::raw('DATE(visits.created_at) as date'), DB::raw('COUNT(*) as count'), 'users.roles')
            ->whereNotNull('visits.logout')  // Ensure we are counting only logouts
            ->whereIn('users.roles', ['sub-admin', 'user'])
            ->groupBy(DB::raw('DATE(visits.created_at)'), 'users.roles')
            ->orderBy('date')
            ->get();
    
        $subAdminData = $logoutData->where('roles', 'sub-admin')->pluck('count', 'date')->toArray();
        $userData = $logoutData->where('roles', 'user')->pluck('count', 'date')->toArray();
        
        // Get course data
        $courseData = DB::table('users')
            ->select('courseID', DB::raw('COUNT(*) as count'))
            ->where('roles', 'user')
            ->groupBy('courseID')
            ->get();
        
        $courses = $courseData->pluck('courseID')->toArray();
        $populations = $courseData->pluck('count')->toArray();
        
        // Get total manuscripts per course
        $manuscriptData = DB::table('manuscripts')
            ->join('users', 'manuscripts.user_id', '=', 'users.id')
            ->select('users.courseID', DB::raw('COUNT(manuscripts.id) as count'))
            ->groupBy('users.courseID')
            ->get();
        
        $manuscriptCourses = $manuscriptData->pluck('courseID')->toArray();
        $manuscriptCounts = $manuscriptData->pluck('count')->toArray();        
        $currentMonth = now()->format('F');
        $currentYear = now()->format('Y');
        // Get dropbox data
        $dropboxData = DB::table('dropboxes')
            ->join('users', 'dropboxes.user_id', '=', 'users.id')
            ->select('users.courseID', DB::raw('COUNT(dropboxes.id) as count'))
            ->groupBy('users.courseID')
            ->pluck('count', 'courseID')
            ->toArray();
        
        $dropboxStatuses = DB::table('dropboxes')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('status')->toArray();
        
        $dropboxCounts = DB::table('dropboxes')
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        // Get total manuscripts and dropboxes
        $totalManuscripts = Manuscript::count();
        $totalDropboxes = Dropbox::count();
        
        // Get total manuscripts and dropboxes for the current month and year
        $currentMonthYear = now()->format('Y-m');
        $currentMonthManuscripts = DB::table('manuscripts')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        
        $currentMonthDropboxes = DB::table('dropboxes')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
        
            $researchDropboxData = DB::table('dropboxes')
            ->join('users', 'dropboxes.user_id', '=', 'users.id')
            ->select('users.courseID', DB::raw('COUNT(dropboxes.id) as count'))
            ->whereIn('dropboxes.status', ['pending', 'approved', 'for revision']) 
            ->groupBy('users.courseID')
            ->pluck('count', 'courseID')
            ->toArray();
        // Get demographic data for 'sub-admin' role
        $subAdminDemographics = DB::table('users')
        ->select('sex', DB::raw('count(*) as total'))
        ->where('roles', 'sub-admin')
        ->groupBy('sex')
        ->get();
        // Get demographic data for 'user' role
        $userDemographics = DB::table('users')
            ->select('sex', DB::raw('count(*) as total'))
            ->where('roles', 'user')
            ->groupBy('sex')
            ->get();

        // Combine the data
        $combinedDemographics = [
            'sub-admin' => $subAdminDemographics,
            'user' => $userDemographics,
        ];

        
        return view('admin.dashboard', [
            'subAdminData' => $subAdminData,
            'userData' => $userData,
            'courses' => $courses,
            'populations' => $populations,
            'manuscriptCourses' => $manuscriptCourses,
            'manuscriptCounts' => $manuscriptCounts,
            'dropboxStatuses' => $dropboxStatuses,
            'dropboxCounts' => $dropboxCounts,
            'totalManuscripts' => $totalManuscripts,
            'totalDropboxes' => $totalDropboxes,
            'currentMonthManuscripts' => $currentMonthManuscripts,
            'currentMonthDropboxes' => $currentMonthDropboxes,
            'currentMonth'=> $currentMonth,
            'currentYear' => $currentYear,
            'researchDropboxData' => $researchDropboxData,
            'combinedDemographics' =>  $combinedDemographics
        ]);
    }
    
    
    public function subIndex() {
        $user = auth()->user();
        if ($user->roles !== 'sub-admin') {
            abort(403, 'Unauthorized');
        }
        $userID = $user->id;
        $manuscripts = Manuscript::where('coordinator_id', $userID)->get();
        $totalManuscripts = Manuscript::where('coordinator_id', $userID)->count();
        $totalDropboxes = Dropbox::where('user_id', $userID)->count();  
        $dropboxStatusData = Dropbox::select('status', DB::raw('COUNT(*) as count'))
            ->where('user_id', $userID)
            ->groupBy('status')
            ->get();
        $statuses = $dropboxStatusData->pluck('status')->toArray();
        $counts = $dropboxStatusData->pluck('count')->toArray();
        $currentMonth = now()->format('F');
        $currentYear = now()->format('Y');
        
        return view('sub.dashboard', compact('manuscripts', 'totalManuscripts', 'totalDropboxes', 'statuses', 'counts', 'currentMonth', 'currentYear'));
    }
    
    public function userIndex(){
        $user = auth()->user();
        if ($user->roles !== 'user') {
            abort(403, 'Unauthorized');
        }
        $userID = $user->id;
        $manuscript = Manuscript::where('user_id',$userID)->first();
        $announcements = Announcement::latest()->get();
        
        return view('user.dashboard', compact('announcements','manuscript'));
    }
}
