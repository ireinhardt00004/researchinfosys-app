<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyToContactUs;
use App\Models\Notification;
use App\Models\User;

class ContactUsController extends Controller
{
    public function index() {
        $user = auth()->user();
        if ($user->roles !== 'admin') {
            abort(403, 'Unauthorized');
        }
        ActivityLog::create([
            'user_id' => $user->id,
            'activity' => 'Visited Contact Us page.'
        ]);
        $logs = ContactUs::latest()->get();
        $userData = $logs->map(function ($log) {
            $createdAt = Carbon::parse($log->created_at);
            return [
                'fullname' => $log->fullname,
                'contactus' => $log->contactus,
                'email' => $log->email,
                'subject' => $log->subject,
                'concern' => $log->concern,
                'timestamp' => $createdAt->format('F d, Y') . ' (' . $createdAt->diffForHumans() . ')',
                'actions' => '
                <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-green-400" onclick="viewContactUs(' . $log->id . ')"><i class="fa-solid fa-eye"></i></button> 
                 <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-slate-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="replyContactUs(' . $log->id . ')"><i class="fa-solid fa-reply"></i></button>          
                 <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="deleteContactUs(' . $log->id . ')"><i class="fa-solid fa-trash"></i></button>
                  ',
            ];
        });

        return view('contactus.index', ['users' => $userData]);
    }

    public function viewContactUs($id)
    {
        $contact = ContactUs::findOrFail($id);
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Viewed a concern.'
        ]);
        return response()->json([
            'fullname' => $contact->fullname,
            'email' => $contact->email,
            'subject' => $contact->subject,
            'concern' => $contact->concern,
            'timestamp' => $contact->created_at->format('F d, Y') . ' (' . $contact->created_at->diffForHumans() . ')'
        ]);
    }

    public function replyContactUs(Request $request, $id)
    {
        $contact = ContactUs::findOrFail($id);
        
        // Validate reply
        $request->validate([
            'reply' => 'required|string',
        ]);
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Sent reply message to a concern.'
        ]);
        // Send email
        Mail::to($contact->email)->send(new ReplyToContactUs($request->reply));

        return response()->json(['success' => true]);
    }
    public function destroy($id) {
        $concern = ContactUs::findOrFail($id);
        $concern->delete();
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Deleted a concern.'
        ]);
        return response()->json(['status' => 'success']);
    }
    
    public function send(Request $request)
    {
        // Validate the request
        $request->validate([
            'fullname' => ['required', 'string', 'max:255'],
            'contactnum' => ['nullable', 'string', 'max:11'], 
            'email' => ['required', 'email', 'max:255'], 
            'subject' => ['required', 'string', 'max:255'],
            'concern' => ['required', 'string'],
        ]);
    
        try {
            // Create a new ContactUs record
            $contact = ContactUs::create([
                'fullname' => $request->fullname,
                'contactnum' => $request->contactnum,
                'email' => $request->email,
                'subject' => $request->subject,
                'concern' => $request->concern
            ]);
    
            // Get all admin IDs
            $adminIds = User::where('roles', 'admin')->pluck('id');
            
            // Send notifications to all admins
            foreach ($adminIds as $adminId) {
                Notification::create([
                    'sender_id' => $adminId,
                    'receiver_id' => $adminId,
                    'message' => 'A concern was sent from the Contact Us form.',
                    'is_read' => false,
                ]);
            }
    
            // Return success response
            return response()->json(['success' => true, 'message' => 'Your concern has been submitted successfully!']);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error handling contact form: ' . $e->getMessage());
            
            // Return error response
            return response()->json(['success' => false, 'message' => 'An error occurred while processing your concern. Please try again later.']);
        }
    }
    
}

