<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manuscript;
use App\Models\ApprovedManuscript;
use App\Models\ActivityLog;

class SubController extends Controller
{
    public function completedIndex(Request $request)
    {
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Completed Research page.',
        ]);
        return view('sub.completed', compact('manuscripts'));
    }

    public function publicationIndex(Request $request)
    {
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Publication page.',
        ]);
        return view('sub.publication', compact('manuscripts'));
    }
    public function approve($id)
    {
    $manuscript = Manuscript::findOrFail($id);
    $manuscript->status = 'approved';
    $manuscript->save();
    ApprovedManuscript::create([
        'tracking_code' => $manuscript->tracking_code,
        'title' => $manuscript->title,
        'user_id' => auth()->user()->id,
        'type' => 'manuscript',
        'author' => $manuscript->author,
    ]);
    ActivityLog::create([
        'user_id' => auth()->user()->id,
        'activity' => 'Approved the submitted manuscript named '.$manuscript->title,
    ]);
    return redirect()->route('reports.index')->with('success', 'Manuscript approved successfully.');
    }


    public function utilizedIndex(Request $request) {
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Utilized Research page.',
        ]);
        return view('sub.utilized', compact('manuscripts'));
    }

    public function citationIndex(Request $request) {
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Citation page.',
        ]);
        return view('sub.citation', compact('manuscripts'));
    }

    public function paperPresentationIndex(Request $request){
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Paper Presentation page.',
        ]);
        return view('sub.paper-presentation', compact('manuscripts'));
    }

    public function researchAwardIndex(Request $request) {
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Research Awards page.',
        ]);
        return view('sub.research-awards', compact('manuscripts'));
    }

    public function inventionUtilityIndex(Request $request) {
        $selectedIDs = $request->query('ids');
        $manuscripts = collect();
       
        if ($selectedIDs) {
            $idsArray = explode(',', $selectedIDs);
            $manuscripts = Manuscript::whereIn('id', $idsArray)->get();
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Invention or Utility Models page.',
        ]);
        return view('sub.invention', compact('manuscripts'));
    }
    
}
