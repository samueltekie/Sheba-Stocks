<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        // Fetch the transactions (you can modify this query as needed)
        $transactions = Transaction::all(); // or you can limit it, e.g., Transaction::latest()->limit(10)

        // Return the view and pass the transactions to the view
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($userId)
    {
        // Fetch transactions for the specific user
        $transactions = Transaction::where('user_id', $userId)->get();

        // Check if transactions exist for that user
        if ($transactions->isEmpty()) {
            return redirect()->back()->with('error', 'No transactions found for this user.');
        }

        // Return the transaction-details view with all transactions for that user
        return view('admin.transactions.transaction-details', compact('transactions'));
    }
}
