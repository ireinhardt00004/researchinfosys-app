<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\UserInfo;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validated();
        // Initialize $user
        $user = auth()->user();

        // Check if a profile picture file was uploaded
        if ($request->hasFile('profile_pic') && $request->file('profile_pic')->isValid()) {
            $file = $request->file('profile_pic');

            // Validate file type
            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = $file->getClientOriginalExtension();

            if (!in_array(strtolower($extension), $allowedFileTypes)) {
                return redirect()->back()->with('error', 'Invalid file format. Please upload an image file with extensions: jpg, jpeg, png, gif.');
            }
            $fileType = 'image';
            $prefix = ($fileType === 'image') ? '2024PROFILE' : 'OTHER';
            $uniqueMediaNumber = $prefix . '-' . uniqid();
            $fileName = $uniqueMediaNumber . '.' . $extension;
            $file->move(public_path('profile_pic'), $fileName);
            $filePath = 'profile_pic/' . $fileName;
            $userInfo = $user->userinfos()->first(); 
            if (!$userInfo) {
                $userInfo = new UserInfo();
                $userInfo->user_id = $user->id; 
            }
            $userInfo->profile_pic = $filePath;
            $userInfo->save(); 
            Log::info('Profile Picture Path:', ['path' => $filePath]);
        }

        // Update the user's profile information
        $user->fill($validatedData);
        $user->save();
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Updated Profile Information'
        ]);
        return Redirect::route('profile.edit')->with('success', 'Profile Information updated successfully.');
    } catch (\Exception $e) {
        // Log the exception and handle errors
        Log::error('Profile update failed', ['exception' => $e]);
        return redirect()->back()->with('error', 'An error occurred while updating the profile.');
    }
}


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
