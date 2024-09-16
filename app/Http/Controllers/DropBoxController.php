<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Dropbox;
use App\Models\ApprovedManuscript;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class DropBoxController extends Controller
{
    public function index() {
        $user = auth()->user();
        if ($user->roles !== 'sub-admin') {
            abort(403, 'Unauthorized');
        }
        $userID = $user->id;
        $manuscripts = Dropbox::where('user_id', $userID)->latest()->get();
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Visited My Drop box'
        ]);
        return view('reports.dropbox', compact('manuscripts')); 
    }

    public function delete($id) {
        $authUser = auth()->user();
        if (!in_array($authUser->roles, ['admin', 'sub-admin'])) {
            abort(403, 'Unauthorized');
        }

        $manuscript = Dropbox::findOrFail($id);
        $title = $manuscript->title;
        
        // Log the deletion
        ActivityLog::create([
            'user_id' =>  $authUser->id,
            'activity' => 'Deleted a report named '.$title
        ]);

        // Extract the filename from file_path
        $filePath = public_path('export_forms/' . $manuscript->file_path);

        // Delete the specific file
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the manuscript record
        $manuscript->delete();

        return response()->json(['success' => 'Manuscript deleted successfully']);
    }

    public function reUpload(Request $request, $id) {
        $user = auth()->user();
        if ($user->roles !== 'sub-admin') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ]);

        $manuscript = Dropbox::findOrFail($id);

        // Extract the existing file path
        $oldFilePath = public_path('export_forms/' . $manuscript->file_path);

        // Delete the old file
        if (file_exists($oldFilePath)) {
            unlink($oldFilePath);
        }

        // Store the new file and get its path
        $newFileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $newFilePath = 'export_forms/' . $newFileName;
        $request->file('file')->move(public_path('export_forms'), $newFileName);
        
        if (strpos($manuscript->title, '(REVISED)') === false) {
            $manuscript->title .= ' (REVISED)';
        }        
        $manuscript->file_path = $newFilePath;
        $manuscript->save();
        $admin = User::where('roles', 'admin')->first();
        if ($admin) {
            Notification::create([
                'sender_id' => $user->id,
                'receiver_id' => $admin->id,
                'message' => 'sent a revised report named ' . $manuscript->title,
                'is_read' => false,
        ]);
}


        return redirect()->back()->with('success', 'File re-uploaded successfully');
    }

    public function revise(Request $request)
    {
        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'manuscript_id' => 'required|exists:dropboxes,id',
            'comments' => 'required|string',
        ]);
        
        $manuscript = Dropbox::findOrFail($request->manuscript_id);
        // Update the status and comments
        $manuscript->status = 'for revision';
        $manuscript->comment = $request->comments;
        $manuscript->save();

        Notification::create([
            'sender_id' => $user->id,
            'receiver_id' => $manuscript->user_id,
            'message' => 'notified you to revise the report named '. $manuscript->title . '. Please check the comments',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Manuscript updated for revision.');
    }

    public function approve($id)
    {
        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $manuscript = Dropbox::findOrFail($id);
        
        // Update the status to approved
        $manuscript->status = 'approved';
        $manuscript->save();
        ApprovedManuscript::create([
            'tracking_code' => $manuscript->tracking_code,
            'title' => $manuscript->title,
            'user_id' => $user->id,
            'coordinator_id' => $manuscript->user_id,
            'type' => 'dropbox'
        ]);
        // Log the approval action
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Approved a report named ' . $manuscript->title
        ]);
        Notification::create([
            'sender_id' => $user->id,
            'receiver_id' => $manuscript->user_id,
            'message' => 'approved your report named '. $manuscript->title,
            'is_read' => false,
        ]);
        return redirect()->back()->with('success', 'Manuscript approved successfully.');
    }
}
