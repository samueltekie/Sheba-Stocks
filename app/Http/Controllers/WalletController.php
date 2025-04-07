<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Wallet;
use App\Models\Transaction; // Import the Transaction model

class WalletController extends Controller
{
    // Show wallet information for the authenticated user
    public function show($id = null) // Allow for optional parameter
{
    // If no ID is provided, get the authenticated user's ID
    $userId = $id ?? auth()->id();

    // Get the user's wallet
    $wallet = Wallet::where('user_id', $userId)->firstOrFail(); // Use firstOrFail to automatically handle the case where the wallet doesn't exist

    // Retrieve the transactions for the user's wallet
    $transactions = Transaction::where('wallet_id', $wallet->id)->get();

    // Filter stock_purchase transactions
    $stockPurchases = Transaction::where('wallet_id', $wallet->id)
                                ->where('type', 'stock_purchase')
                                ->get();

    // Pass the wallet and transactions data to the view
    return view('wallet.show', compact('wallet', 'transactions', 'stockPurchases'));
}
    public function fetchStockData($symbol) {
        $client = new Client();
        $response = $client->get('https://finnhub.io/api/v1/quote?symbol='.$symbol.'&token=YOUR_API_KEY');
        return json_decode($response->getBody()->getContents(), true);
    }

    public function deposit(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
    ]);

    $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();
    $amount = $request->input('amount');
    $wallet->total_balance += $amount;
    $wallet->available_balance += $amount;
    $wallet->save();

    // Record the deposit transaction
    Transaction::create([
        'user_id' => auth()->id(),
        'wallet_id' => $wallet->id, // Associate the transaction with the wallet
        'type' => 'deposit',
        'amount' => $amount,
        'details' => 'Added funds to wallet'
    ]);

    return redirect()->back()->with('message', 'Deposit successful');
}

    public function withdraw(Request $request) {
        $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();
        $amount = $request->input('amount');

        if ($wallet->available_balance >= $amount) {
            $wallet->total_balance -= $amount;
            $wallet->available_balance -= $amount;
            $wallet->save();

            Transaction::create([
                'user_id' => auth()->id(),
            'wallet_id' => $wallet->id, // Associate the transaction with the wallet
                'type' => 'withdrawal',
                'amount' => $amount,
                'details' => 'Withdrew funds from wallet'
            ]);

            return redirect()->back()->with('message', 'Withdrawal successful');
        }

        return redirect()->back()->with('error', 'Insufficient balance');
    }
}