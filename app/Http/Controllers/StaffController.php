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
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class StaffController extends Controller
{
    public function registerStaff(Request $request) {
        // Validate the request data
        $validatedData = $request->validate([
            'studnum' => [
                'nullable',
                'string',
                'regex:/^\d{4}-\d{3}-\d{3}$/',
                'max:255',
                Rule::unique('users', 'studnum')
            ],
            'lname' => ['required', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'sex' => ['required', 'string'],
            'courseID' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                'regex:/^[a-zA-Z0-9._%+-]+@cvsu\.edu\.ph$/'
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.regex' => 'Please use your CVSU Email address.'
        ]);
    
        try {
            // Create the user
            $user = User::create([
                'studnum' => $request->studnum,
                'lname' => $request->lname,
                'fname' => $request->fname,
                'middlename' => $request->middlename,
                'sex' => $request->sex,
                'courseID' => $request->courseID,
                'roles' => 'sub-admin',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verified' => true,
            ]);
    
            // Log the creation event
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Registered a new staff member with ID ' . $user->id
            ]);
    
            return response()->json(['success' => 'Staff registered successfully.']);
    
        } catch (Exception $e) {
            Log::error('Error registering staff: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while registering the staff.'], 500);
        }
    }
    
    
    public function index() {

        $authUser = auth()->user();
        $rolesArray = explode(',', $authUser->roles);
    
        if (!in_array('admin', $rolesArray)) {
            abort(403, 'Unauthorized');
        }
        
        $users = User::where('verified', true)
                    ->whereIn('roles', ['sub-admin'])
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

        return view('accounts.permit', ['users' => $userData]);
    }
    public function userlist() {
        $authUser = auth()->user();
        $rolesArray = explode(',', $authUser->roles);
    
        if (!in_array('admin', $rolesArray)) {
            abort(403, 'Unauthorized');
        }
        
        $users = User::where('verified', true)
                    ->whereIn('roles', ['sub-admin', 'user'])
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
}
