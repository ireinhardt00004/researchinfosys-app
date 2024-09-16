<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Mail\EventNotification;
use Illuminate\Support\Facades\Mail;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Event::all();
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Visited Event Calendar page.',
            ]);
            $calendarEvents = Event::all()->map(function ($event) {
                return [
                    'title' => $event->title,
                    'start' => $event->start_datetime,
                    'end' => $event->end_datetime,
                    'description' => $event->description,
                    'type' => $event->type,
                ];
            });
            
            return view('admin.event-calendar', compact('calendarEvents','events'));
        } catch (\Exception $e) {
            Log::error('Error fetching events: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load events.');
        }
    }

    public function store(Request $request)
{
    $authUser = auth()->user();
    if (!in_array($authUser->roles, ['admin', 'sub-admin'])) {
        abort(403, 'Unauthorized');
    }

    try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:Regular Holiday,Special Holiday,Others',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
        ]);

        $validated['user_id'] = $authUser->id; 

        Event::create($validated);

        Log::info('Event created successfully: ' . $validated['title']);

        // Fetch all users with the role 'resident'
        $users = User::where('roles', 'user')->get();

        // Debugging information
        \Log::info('Number of users found: ' . $users->count());

        // Check each user
        foreach ($users as $user) {
            \Log::info('user ID: ' . $user->id . ', Name: ' . $user->name);
        }

        // Create a notification for each user
        foreach ($users as $user) {
            Notification::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $user->id,
                'message' => 'A new event has been posted.',
                'is_read' => 0, 
            ]);
        }

        // Notify users via email if the checkbox is checked
        if ($request->notify_residents) {
            foreach ($users as $user) {
                Mail::to($user->email)->send(new EventNotification($validated));
            }
        }
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Posted new event.',
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Event created successfully.'
        ]);
    } catch (\Exception $e) {
        Log::error('Error creating event: ' . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to create event. Please try again later.'
        ], 500);
    }
}   

    public function destroy($id)
    {
    try {
        $event = Event::findOrFail($id);
        $event->delete();

        Log::info('Event deleted successfully: ' . $event->title);
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Deleted an event.',
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Event deleted successfully.'
        ]);
    } catch (\Exception $e) {
        Log::error('Error deleting event: ' . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => 'Failed to delete event. Please try again later.'
        ], 500);
    }
}

}
