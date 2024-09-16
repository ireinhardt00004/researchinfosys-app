<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountVerified;
use App\Mail\RegistrationDeclined;
use Exception;
use Log;
use App\Models\Notification;

class AccountManagementController extends Controller
{
    public function userlist() {
        $authUser = auth()->user();
        $rolesArray = explode(',', $authUser->roles);
    
        if (!in_array('admin', $rolesArray)) {
            abort(403, 'Unauthorized');
        }
        
        $users = User::where('verified', true)
                    ->whereIn('roles', ['user'])
                    ->get();
        
        $userData = $users->map(function ($user) {
            return [
                'roles' => $user->roles,
                'uid' => $user->studnum,
                'fullname' => $user->fname . ' ' . $user->middlename . ' ' . $user->lname,
                'email' => $user->email,
                'courseID' => $user->courseID,
                'actions' => '
                    <button style="background-color: blue;" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400" onclick="mod_request(3, \'' . $user->id . '\')" title="Edit Credentials"><i class="fa-solid fa-edit"></i></button>
                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="mod_request(2, \'' . $user->id . '\')" title="Delete User Account"><i class="fa-solid fa-x"></i></button>
                ',
            ];
        });

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited User List page.'
        ]);

        return view('accounts.userlist', ['users' => $userData]);
    }

    public function editCredentials(Request $request, $id)
    {
        $request->validate([
            'admin_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $adminPassword = $request->input('admin_password');
        $newPassword = $request->input('new_password');

        // Verify admin password
        if (!Hash::check($adminPassword, auth()->user()->password)) {
            return response()->json(['error' => 'Admin password is incorrect.'], 403);
        }
        
        $user = User::find($id);
        $user->password = Hash::make($newPassword);
        $user->save();

        return response()->json(['success' => 'User credentials updated successfully.']);
    }

    public function deleteUser(Request $request, $id)
    {
        $request->validate([
            'admin_password' => 'required',
        ]);

        $adminPassword = $request->input('admin_password');

        // Verify admin password
        if (!Hash::check($adminPassword, auth()->user()->password)) {
            return response()->json(['error' => 'Admin password is incorrect.'], 403);
        }

        User::destroy($id);

        return response()->json(['success' => 'User account deleted successfully.']);
    }

    public function index() {
        $authUser = auth()->user();
        $rolesArray = explode(',', $authUser->roles);
    
        if (!in_array('admin', $rolesArray)) {
            abort(403, 'Unauthorized');
        }
        
        $users = User::where('verified', false)
                    ->whereIn('roles', ['sub-admin', 'user'])
                    ->get();
        
        $userData = $users->map(function ($user) {
            return [
                'uid' => $user->studnum,
                'fullname' => $user->fname . ' ' . $user->middlename . ' ' . $user->lname,
                'email' => $user->email,
                'courseID' => $user->courseID,
                'actions' => '
                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" onclick="mod_request(2, \'' . $user->id . '\')"><i class="fa-solid fa-x"></i></button>
                    <button style="background-color: blue;" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400" onclick="mod_request(3, \'' . $user->id . '\')"><i class="fa-solid fa-check"></i></button>
                ',
            ];
        });

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Validate Account page.'
        ]);

        return view('accounts.index', ['users' => $userData]);
    }

    public function approveUser(int $id)
    {
        $authUser = auth()->user();
        $rolesArray = explode(',', $authUser->roles);
        
        if (!in_array('admin', $rolesArray)) {
            abort(403, 'Unauthorized');
        }
        
        Log::info("Approve User called for ID: {$id}");   
        $user = User::findOrFail($id);
        $fullName = trim($user->fname .' '. $user->middlename .' '. $user->lname);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Verified the account of ' . $fullName,
        ]);
        Notification::create([
            'sender_id' => $authUser->id,
            'receiver_id' => $user->id,
            'message' => 'successfully verified your registration.',
            'is_read' => false
        ]);
        $user->update(['verified' => true]);
        Log::info("User approved successfully: ", $user->toArray());

        // Send verification email
        try {
            Mail::to($user->email)->send(new AccountVerified($user));
        } catch (Exception $e) {
            Log::error('Error in approving user: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to send verification email.']);
        }

        return response()->json(['success' => true, 'message' => 'User verified successfully.']);
    }

    public function declineUser(int $id)
    {
        $authUser = auth()->user();
        $rolesArray = explode(',', $authUser->roles);
        
        if (!in_array('admin', $rolesArray)) {
            abort(403, 'Unauthorized');
        }

        Log::info("Decline User called for ID: {$id}");

        try {
            $user = User::findOrFail($id);
            $fullName = trim($user->fname .' '. $user->middlename .' '. $user->lname);

            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Declined the account of ' . $fullName,
            ]);

            // Send decline notification email
            try {
                Mail::to($user->email)->send(new RegistrationDeclined($user));
            } catch (Exception $e) {
                Log::error('Error in sending decline email: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'Failed to send decline notification email.']);
            }

            // Delete the user
            $user->forceDelete(); 
            Log::info("User declined successfully: ", $user->toArray());

            return response()->json(['success' => true, 'message' => 'User declined successfully.']);
        } catch (Exception $e) {
            Log::error("Error in declining user: {$e->getMessage()}");
            return response()->json(['success' => false, 'message' => 'User decline failed.']);
        }
    }
}
