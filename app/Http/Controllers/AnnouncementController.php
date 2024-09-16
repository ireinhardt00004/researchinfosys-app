<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Notification;

class AnnouncementController extends Controller
{
    public function create()
    {
        $authUser = auth()->user();
        if (!in_array( $authUser->roles, ['admin', 'sub-admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('announcement.create');
    }

    public function store(Request $request)
{   
    $authUser = auth()->user();
    if (!in_array($authUser->roles, ['admin', 'sub-admin'])) {
        abort(403, 'Unauthorized');
    }

    $validated = $request->validate([
        'event-title' => 'required|string|max:255',
        'event-content' => 'required|string',
        'imageFilez' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $title = $validated['event-title'];
    $content = $validated['event-content'];
    $cover = 'bg-img2.jpg';

    if ($request->hasFile('imageFilez')) {
        $file = $request->file('imageFilez');
        $destinationPath = public_path('announcement_img');

        // Ensure the directory exists
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $filename = time() . '-' . $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $cover = $filename;
    }

    Announcement::create([
        'cover' => $cover,
        'title' => $title,
        'content' => $content,
        'user_id' => auth()->user()->id,
    ]);

    $titlezx = $validated['event-title'];

    ActivityLog::create([
        'user_id' => auth()->user()->id,
        'activity' => 'Created a new announcement entitled ' . $titlezx
    ]);

    // Fetch all users with the role 'user'
    $users = User::where('roles', 'user')->get();

    // Debugging information
    \Log::info('Number of users found: ' . $users->count());

    // Check each user
    foreach ($users as $user) {
        \Log::info('user ID: ' . $user->id . ', Name: ' . $user->lname);
    }

    // Create a notification for each user
    foreach ($users as $user) {
        Notification::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $user->id,
            'message' => 'A new announcement named "' . $titlezx . '" has been posted.',
            'is_read' => 0, 
        ]);
    }

    \Log::info("Added new announcement with title '$titlezx'");

    return response()->json([
        'status' => 'success',
        'message' => 'Announcement created successfully.',
        'redirect' => route('newsfeed.index')
    ]);
}

    public function edit($id)
    {   
        $authUser = auth()->user();
        if (!in_array( $authUser->roles, ['admin', 'sub-admin'])) {
            abort(403, 'Unauthorized');
        }
        // Fetch the announcement to edit
        $announcement = Announcement::findOrFail($id);

        // Return the view to edit the announcement
        return view('announcement.edit', compact('announcement'));
    }

    public function update(Request $request, $id)
    {
        try {
            $authUser = auth()->user();
            if (!in_array( $authUser->roles, ['admin', 'sub-admin'])) {
                abort(403, 'Unauthorized');
            }
            // Validate the request data
            $validatedData = $request->validate([
                'event-title' => 'required|string|max:255',
                'event-content' => 'required|string',
                'imageFilez' => 'nullable|image|mimes:jpg,png,gif,jpeg|max:2048',
            ]);
    
            // Find the announcement or fail
            $announcement = Announcement::findOrFail($id);
    
            // Handle image file upload
            if ($request->hasFile('imageFilez')) {
                // If there is an existing image, delete it
                if ($announcement->cover && file_exists(public_path('announcement_img/' . $announcement->cover))) {
                    unlink(public_path('announcement_img/' . $announcement->cover));
                }
    
                // Store the new image with its original filename
                $image = $request->file('imageFilez');
                $originalImageName = $image->getClientOriginalName(); // Get original filename
                $image->move(public_path('announcement_img'), $originalImageName);
    
                // Encrypt the filename and update the announcement's cover
                $encryptedImageName = $originalImageName;
                $announcement->cover = $encryptedImageName;
            }
    
            // Update the announcement details
            $announcement->title = $request->input('event-title');
            $announcement->content = $request->input('event-content');
            $announcement->save();
    
            // Log the activity
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Updated an announcement entitled ' . $request->input('event-title')
            ]);
    
            // Return success response
            return response()->json([
                'status' => 'success',
                'message' => 'Announcement updated successfully.',
                'redirect' => route('newsfeed.index')
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Announcement not found.'
            ]);
        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update the announcement.'
            ]);
        }
    }
    

    public function destroy(Request $request, $id)
{
    try {
        $authUser = auth()->user();
        if (!in_array( $authUser->roles, ['admin', 'sub-admin'])) {
            abort(403, 'Unauthorized');
        }
        // Validate the input
        // $id = intval($request->input('id'));

        // Find the announcement or fail
        $announcement = Announcement::findOrFail($id);

        // Log the activity
        $title = $announcement->title;
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Deleted an announcement entitled ' . $title
        ]);

        // Delete the announcement
        $announcement->forceDelete();

        // Redirect back with success message
        return redirect()->route('newsfeed.index')->with('success', 'Announcement deleted successfully.');

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Redirect back with error message
        return redirect()->route('newsfeed.index')->with('error', 'Announcement not found.');
    } catch (\Exception $e) {
        // Redirect back with error message
        return redirect()->route('newsfeed.index')->with('error', 'Failed to delete the announcement.');
    }
}
}
