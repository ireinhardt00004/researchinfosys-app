<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApprovedManuscript;
use Carbon\Carbon;

class DataManagementController extends Controller
{
    public function index(Request $request) {
        $authUser = auth()->user();
        if (!in_array($authUser->roles, ['admin', 'sub-admin'])) {
            abort(403, 'Unauthorized');
        }
    
        $year = $request->input('year', date('Y'));
    
        // Fetch manuscript data for the selected year
        $manuscriptsData = ApprovedManuscript::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('type', 'manuscript')
            ->groupBy('month')
            ->get();
    
        // Fetch dropbox data for the selected year
        $dropboxData = ApprovedManuscript::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('type', 'dropbox')
            ->groupBy('month')
            ->get();
    
        return view('datamng.index', compact('manuscriptsData', 'dropboxData', 'year'));
    }
    
}
