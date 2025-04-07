@extends('layouts.admin')

@section('content')
    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <h1 class="page-title">Admin Dashboard</h1>
    </div>

    <!-- Stats Section -->
    <div class="dashboard-stats">
        <div class="stats-card">
            <h3>Total Users</h3>
            <p class="stat-value">{{ $totalUsers ?? 'N/A' }}</p>
        </div>
        <div class="stats-card">
            <h3>KYC Approved</h3>
            <p class="stat-value">{{ $kycApproved ?? 'N/A' }}</p>
        </div>
        <div class="stats-card">
            <h3>KYC Rejected</h3>
            <p class="stat-value">{{ $kycrejected ?? '0' }}</p>
        </div>
        <div class="stats-card">
            <h3>KYC Pending</h3>
            <p class="stat-value">{{ $kycPending ?? 'N/A' }}</p>
        </div>
        <div class="stats-card">
            <h3>Total Transactions</h3>
            <p class="stat-value">{{ $transactions ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Recent Users Section -->
    <div class="recent-users">
        <h2>Recent Users</h2>
        <ul>
            @forelse($recentUsers as $user)
                <li class="user-item">
                    <div class="user-info">
                        <strong>{{ $user->name }}</strong>
                        <p class="user-email">{{ $user->email }}</p>
                    </div>
                </li>
            @empty
                <li>No recent users available.</li>
            @endforelse
        </ul>
    </div>

    <!-- Recent Transactions Section -->
    <div class="recent-transactions">
        <h2>Recent Transactions</h2>
        <ul>
            @forelse($recentTransactions as $transaction)
                <li class="transaction-item">
                    <div class="transaction-details">
                        <p><strong>{{ $transaction->details }}</strong></p>
                        <p class="transaction-amount">${{ number_format($transaction->amount, 2) }}</p>
                    </div>
                </li>
            @empty
                <li>No recent transactions available.</li>
            @endforelse
        </ul>
    </div>

    <!-- Add custom styling in the blade file itself or link an external stylesheet -->
    <style>
        /* Dashboard Header */
        body{
            background-color: #154734;
        }
        .dashboard-header {
            background-color: #154734;
            color: white;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: bold;
        }

        /* Stats Section */
        .dashboard-stats {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 40px;
        }

        .stats-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            width: calc(33.333% - 20px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease-in-out;
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .stats-card h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #e74c3c;
        }

        /* Recent Users Section */
        .recent-users {
            margin-bottom: 40px;
        }

        .recent-users h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #34495e;
        }

        .user-item {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            font-size: 1.1rem;
            color: #34495e;
        }

        .user-email {
            font-size: 1rem;
            color: #7f8c8d;
        }

        /* Recent Transactions Section */
        .recent-transactions {
            margin-bottom: 40px;
        }

        .recent-transactions h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #34495e;
        }

        .transaction-item {
            background-color: #fff;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .transaction-details {
            font-size: 1.1rem;
            color: #34495e;
        }

        .transaction-amount {
            font-size: 1.5rem;
            font-weight: bold;
            color: #27ae60;
        }
    </style>
@endsection
