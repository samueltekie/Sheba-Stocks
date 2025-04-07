<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Add any logic needed for the user dashboard view
        return view('dashboard'); // Ensure you have a 'resources/views/dashboard.blade.php' file
    }
}