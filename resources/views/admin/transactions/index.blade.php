@extends('layouts.admin')

@section('content')
<h1 style="color: #D4AF37; text-align: center;">Transactions based on Users</h1>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #154734; /* Deep Blue */
        color: #fff;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .toggle-btn {
        background-color: #D4AF37; /* Gold */
        color: white;
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        text-decoration: none;
    }

    .toggle-btn:hover {
        background-color: #0D3B66; /* Deep Blue */
    }

    .transaction-row {
        display: none;
        transition: all 0.3s ease;
        padding-left: 40px;
    }

    .user-row td {
        background-color: #e7f3ff;
        font-weight: bold;
    }

    .transaction-row td {
        background-color: #f9f9f9;
    }

    .transaction-row td a {
        color: #D4AF37; /* Gold */
        text-decoration: none;
    }

    .transaction-row td a:hover {
        text-decoration: underline;
    }
</style>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @php
            $groupedTransactions = $transactions->groupBy('user_id');
        @endphp
        
        @foreach($groupedTransactions as $userId => $userTransactions)
            <!-- Group Header Row for User ID -->
            @foreach($userTransactions as $index => $transaction)
                @if ($index == 0)
                    <!-- First row for each user with ID and User ID -->
                    <tr class="user-row">
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user_id }}</td>
                        <td>
                        <a href="{{ route('transactions.show', $userId) }}" class="toggle-btn">View</a>
                        </td>
                    </tr>
                @endif
            @endforeach

            <!-- Transactions for this User ID (Hidden initially) -->
            @foreach($userTransactions as $transaction)
                <tr class="transaction-row transaction-{{ $userId }}">
                    <td colspan="3">
                        <strong>Type:</strong> {{ $transaction->type }}<br>
                        <strong>Amount:</strong> ${{ number_format($transaction->amount, 2) }}<br>
                        <strong>Details:</strong> {{ $transaction->details }}<br>
                        <strong>Date:</strong> {{ $transaction->created_at }}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

<br><br><br><br><br><br><br><br><br><br>
<h1 style="color: #D4AF37; text-align: center;">All Transactions</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Type</th>
            <th>Amount</th>
            <th>Details</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $transaction)
        <tr>
            <td>{{ $transaction->id }}</td>
            <td>{{ $transaction->user_id }}</td>
            <td>{{ $transaction->type }}</td>
            <td>${{ number_format($transaction->amount, 2) }}</td>
            <td>{{ $transaction->details }}</td>
            <td>{{ $transaction->created_at }}</td>
            <td>
                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="toggle-btn">View</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
