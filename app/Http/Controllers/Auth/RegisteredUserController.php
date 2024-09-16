<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccess;
use App\Models\UserInfo;
use App\Models\Notification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }
    public function success() 
    {
        return view('success-msg');
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            // Custom validation rules
            $request->validate([
                'studnum' => [
                    'required',
                    'string',
                    'regex:/^\d{4}-\d{3}-\d{3}$/',
                    'max:255',
                    Rule::unique('users')
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
                    Rule::unique('users'),
                    'regex:/^[a-zA-Z0-9._%+-]+@cvsu\.edu\.ph$/'
                ],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ], [
                'email.regex' => 'Please use your CVSU Email address.'
            ]);
    
            // Check if the full name already exists
            $exists = User::where('lname', $request->lname)
                ->where('fname', $request->fname)
                ->where('middlename', $request->middlename)
                ->exists();
    
            if ($exists) {
                return back()->withErrors(['full_name' => 'The full name already exists.'])->withInput();
            }
    
            // Create the user
            $user = User::create([
                'studnum' => $request->studnum,
                'lname' => $request->lname,
                'fname' => $request->fname,
                'middlename' => $request->middlename,
                'sex' => $request->sex,
                'courseID' => $request->courseID,
                'roles' => 'user',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verified' => false,
            ]);
            $user->save();
    
            // // Handle profile picture upload
            // $filename = null; // Default to null if no image is uploaded
            // if ($request->hasFile('profile_pic')) {
            //     $profilePic = $request->file('profile_pic');
            //     $filename = time() . '.' . $profilePic->getClientOriginalExtension();
            //     $profilePic->move(public_path('profile_pic'), $filename);
            // }
    
            // // Create UserInfo with the newly created user's ID
            // UserInfo::create([
            //     'userID' => $user->id,
            //     'profile_pic' => $filename,
            // ]);

            $admin = User::where('roles','admin')->first();
            Notification::create([
                    'sender_id' => $user->id,
                    'receiver_id' => $admin->id,
                    'message' => 'has successfully created an account. Check the Validate Account to verify their registration',
                    'is_read' => false
            ]);
            // Send registration success email
            Mail::to($user->email)->send(new RegistrationSuccess($user));
    
            // Redirect to the success message view
           return redirect()->route('registration.success');
         
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (QueryException $e) {
            return back()->withErrors(['database_error' => 'Database error: ' . $e->getMessage()])->withInput();
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()])->withInput();
        }
    }
    

}