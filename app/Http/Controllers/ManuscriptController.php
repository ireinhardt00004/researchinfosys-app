<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manuscript;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\ActivityLog;

class ManuscriptController extends Controller
{
    public function submitIndex()
    {
        $userID = auth()->user()->id;
        $manuscripts = Manuscript::where('user_id', $userID)->get();
        $subAdmins = User::where('roles', 'sub-admin')->get();
        $userHasManuscript = Manuscript::where('user_id', Auth::id())->exists();
        return view('user.submit-file', compact('manuscripts', 'subAdmins','userHasManuscript'));
    }
    public function store(Request $request)
{
    $request->validate([
        'authors' => 'required|array|min:1',
        'authors.*' => 'string|max:255',
        'title' => 'required|string|max:255',
        'section' => 'required|string|max:4',
        'adviser' => 'required|string|max:255',
        'technical_critic' => 'required|string|max:255',
        'eng_critic' => 'required|string|max:255',
        'file' => 'required|file|mimes:pdf|max:10240',
        'coordinator_id' => 'required|exists:users,id',
        'project_leader_staff' => 'nullable|string|max:255',
        'campus_college' => 'nullable|string|max:255',
        'date_started' => 'nullable|date',
        'date_completed' => 'nullable|date',
        'fund_amount' => 'nullable|numeric|min:0',
    ]);

    $userID = auth()->user()->id;
    $existingManuscript = Manuscript::where('user_id', $userID)->first();

    // Handling file upload
    $file = $request->file('file');
    $fileName = time() . '_' . $file->getClientOriginalName();
    $filePath = 'manuscripts/' . $fileName;
    $file->move(public_path('manuscripts'), $fileName);

    // Prepare authors array with keys
    $authors = $request->input('authors');
    $authorsData = [];
    foreach ($authors as $index => $author) {
        $authorsData['author_' . ($index + 1)] = $author;
    }

    // Convert the authors array to JSON
    $authorsJson = json_encode($authorsData);

    // Prepare manuscript data with new fields
    $manuscriptData = [
        'author' => $authorsJson, // Storing authors as a JSON string
        'title' => $request->input('title'),
        'section' => $request->input('section'),
        'file_path' => $filePath,
        'status' => 'pending',
        'adviser' => $request->input('adviser'),
        'technical_critic' => $request->input('technical_critic'),
        'eng_critic' => $request->input('eng_critic'),
        'coordinator_id' => $request->input('coordinator_id'),
        'user_id' => $userID,
        'project_leader_staff' => $request->input('project_leader_staff'),
        'campus_college' => $request->input('campus_college'),
        'date_started' => $request->input('date_started'),
        'date_completed' => $request->input('date_completed'),
        'fund_amount' => $request->input('fund_amount'),
    ];

    if ($existingManuscript) {
        // Delete the existing file if a manuscript already exists
        $existingFilePath = public_path($existingManuscript->file_path);
        if (file_exists($existingFilePath)) {
            unlink($existingFilePath); // Delete the existing file
        }
        // Update the existing manuscript record
        $existingManuscript->update($manuscriptData);

        return redirect()->back()->with('success', 'Manuscript updated successfully, and the previous file was deleted.');
    } else {
        // Create a new manuscript record if not exists
        Manuscript::create($manuscriptData);
        // Create a notification for the coordinator
        Notification::create([
            'sender_id' => $userID,
            'receiver_id' => $request->input('coordinator_id'),
            'message' => 'submitted a manuscript entitled, ' . $request->input('title'),
        ]);
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'submitted a manuscript entitled, ' . $request->input('title'),
        ]);
        return redirect()->back()->with('success', 'Manuscript submitted successfully.');
    }
}

    public function destroy($id)
    {
    $manuscript = Manuscript::findOrFail($id);
    
    // Optionally, delete the file from storage
    Storage::delete($manuscript->file_path);
    
    $manuscript->delete();
    ActivityLog::create([
        'user_id' => auth()->user()->id,
        'activity' => 'Deleted a Manuscript',
    ]);
    return redirect()->back()->with('success', 'Manuscript deleted successfully.');
    }

    public function show($id)
    {
        $manuscripts = Manuscript::findOrFail($id);
        $subAdmins = User::where('roles', 'sub-admin')->get();
        $userHasManuscript = Manuscript::where('user_id', $id)->exists();
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Viewed Researcher Details',
        ]);
        return view('admin.submit-file', compact('manuscripts', 'subAdmins'));
    }
    
    public function viewManuscripts($id)
    {
        $manuscripts = Manuscript::where('user_id', $id)->get();
        $subAdmins = User::where('roles', 'sub-admin')->get();
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Viewed Researcher Details',
        ]);
        return view('admin.submit-file', compact('manuscripts', 'subAdmins'));
    }
}
