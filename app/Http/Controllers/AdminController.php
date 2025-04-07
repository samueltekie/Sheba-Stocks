<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Models\KycVerificationStage; // Ensure this is being imported

class AdminController extends Controller
{
    public function dashboard()
    {
        // Fetch data for the dashboard
        $totalUsers = User::count();
        
        
        // Pass data to the view
        return view('admin.dashboard', compact('totalUsers'));
    }
    // Add to AdminController
public function usersIndex()
{
    $users = User::all();
    return view('admin.users.index', compact('users'));
}

public function editUser($id)
{
    $user = User::find($id);
    return view('admin.users.edit', compact('user'));
}

public function updateUser(Request $request, $id)
{
    $user = User::find($id);
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->role = $request->input('role');
    $user->save();
    
    return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
}

public function deleteUser($id)
{
    $user = User::find($id);
    $user->delete();
    
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
}

}