<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\KycVerificationStage;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetching data from the database
        $totalUsers = User::count();
        $kycApproved = KycVerificationStage::where('status', 'approved')->count();
        $kycPending = KycVerificationStage::where('status', 'pending')->count();
        $transactions = Transaction::count();
        $recentUsers = User::latest()->take(5)->get();
        $recentTransactions = Transaction::latest()->take(5)->get();

        // Add debug log to confirm this method is being called
        \Log::info('Admin Dashboard Controller is being accessed', [
            'totalUsers' => $totalUsers,
            'recentUsers' => $recentUsers,
        ]);

        // Use dd() to check the content of these variables
        
        

        // If everything looks good, pass the data to your view
        return view('admin.dashboard', compact(
            'totalUsers',
            'kycApproved',
            'kycPending',
            'transactions',
            'recentUsers',
            'recentTransactions'
        ));
    }
}
