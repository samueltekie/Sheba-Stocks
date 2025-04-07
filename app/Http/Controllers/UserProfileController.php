<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserProfileController extends Controller
{
    // Show the user's profile
    public function showProfile()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    // Update the user's profile
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255', // Changed from 'username' to 'name' based on your migration
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'date_of_birth' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $user->update($request->all());

        // Handle file upload for profile picture
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Other methods for password management, KYC, etc.
    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = auth()->user();

    // Check if the current password matches
    if (!\Hash::check($request->current_password, $user->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
    }

    // Update the password
    $user->password = bcrypt($request->new_password);
    $user->save();

    return redirect()->back()->with('success', 'Password updated successfully.');
}
// UserProfileController.php
public function uploadKycDocument(Request $request)
{
    $request->validate([
        'document_type' => 'required|string',
        'document' => 'required|file|mimes:jpeg,png,pdf|max:2048', // Validate file type
    ]);

    $path = $request->file('document')->store('kyc_documents', 'public');

    KycDocument::create([
        'user_id' => auth()->id(),
        'document_type' => $request->input('document_type'),
        'document_path' => $path,
        'verified' => false,
    ]);

    return redirect()->back()->with('success', 'KYC document uploaded successfully.');
}
// UserProfileController.php
public function deactivateAccount()
{
    $user = auth()->user();
    $user->account_status = 'suspended';
    $user->save();

    auth()->logout();

    return redirect()->route('login')->with('status', 'Your account has been deactivated.');
}
public function deleteAccount()
{
    $user = auth()->user();

    $user->delete(); // Soft delete or hard delete depending on setup

    auth()->logout();

    return redirect()->route('login')->with('status', 'Your account has been deleted.');
}
}