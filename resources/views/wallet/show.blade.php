@extends('layouts.app')
@extends('layouts.nav')

@section('content')

<!-- Centering Container -->
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="container max-w-4xl mx-auto py-10">
        
        <!-- Wallet Overview -->
        <div class="bg-white shadow-lg rounded-lg p-8 mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Your Wallet</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-5 bg-green-100 rounded-lg shadow">
                    <h2 class="text-xl font-semibold text-green-800">Total Balance</h2>
                    <p class="text-3xl font-bold text-green-600 mt-2">${{ number_format((float)$wallet->total_balance, 2) }}</p>
                </div>

                <div class="p-5 bg-blue-100 rounded-lg shadow">
                    <h2 class="text-xl font-semibold text-blue-800">Available Balance</h2>
                    <p class="text-3xl font-bold text-blue-600 mt-2">${{ number_format((float)$wallet->available_balance, 2) }}</p>
                </div>

                <div class="p-5 bg-yellow-100 rounded-lg shadow">
                    <h2 class="text-xl font-semibold text-yellow-800">Invested Amount</h2>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">${{ number_format((float)$wallet->invested_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Display Success and Error Messages -->
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
        @endif

        <!-- Recent Transactions -->
        <div class="bg-white shadow-lg rounded-lg p-8 mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Recent Transactions</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="py-3 px-6 text-left text-gray-700">Date</th>
                            <th class="py-3 px-6 text-left text-gray-700">Type</th>
                            <th class="py-3 px-6 text-left text-gray-700">Amount</th>
                            <th class="py-3 px-6 text-left text-gray-700">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($transactions->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center py-6 text-gray-500">No transactions found.</td>
                            </tr>
                        @else
                            @foreach ($transactions as $transaction)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-4 px-6">{{ $transaction->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-3 py-1 rounded-full 
                                        {{ $transaction->type === 'deposit' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">${{ number_format($transaction->amount, 2) }}</td>
                                <td class="py-4 px-6">{{ $transaction->details }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Deposit and Withdraw Funds -->
        <div class="bg-white shadow-lg rounded-lg p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <!-- Deposit Funds -->
                <div class="p-6 border-r border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Deposit Funds</h2>
                    <form action="{{ route('wallet.deposit') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="number" name="amount" step="0.01" placeholder="Amount" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-green-400">
                        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded transition">Deposit</button>
                    </form>
                </div>

                <!-- Withdraw Funds -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Withdraw Funds</h2>
                    <form action="{{ route('wallet.withdraw') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="number" name="amount" step="0.01" placeholder="Amount" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-red-400">
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded transition">Withdraw</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
