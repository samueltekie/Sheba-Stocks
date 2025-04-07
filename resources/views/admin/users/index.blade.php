@extends('layouts.admin')

@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <h1>All Users</h1>
    </div>

    <!-- User Table Section -->
    <div class="user-table-container">
        <table class="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr class="user-row">
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="user-info">
                                <span>{{ $user->name }}</span>
                                @if($user->kyc_status === 'approved')
                                    <img src="/images/verified-symbol.jpg" alt="Verified" class="verified-icon">
                                @endif
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-view">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Add custom styling -->
    <style>
        /* Page Title */
        .page-title {
            margin-bottom: 20px;
            text-align: center;
        }

        .page-title h1 {
            font-size: 2.5rem;
            color: #2c3e50;
            font-weight: bold;
        }

        /* User Table Container */
        .user-table-container {
            margin-top: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Table Styling */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .user-table th, .user-table td {
            padding: 15px;
            text-align: center;
            font-size: 1.1rem;
            color: #34495e;
        }

        .user-table th {
            background-color: #154734;
            color: white;
            font-weight: bold;
        }

        .user-table td {
            background-color: #f9f9f9;
            border-bottom: 1px solid #e1e1e1;
        }

        .user-table tr:hover {
            background-color: #ecf0f1;
            cursor: pointer;
        }

        /* Verified Icon */
        .verified-icon {
            width: 20px;
            height: 20px;
            margin-left: 10px;
        }

        /* KYC Status Styling */
        .kyc-status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .kyc-status.approved {
            background-color: #2ecc71;
            color: white;
        }

        .kyc-status.pending {
            background-color: #f39c12;
            color: white;
        }

        /* Actions Button */
        .btn {
            padding: 8px 16px;
            font-size: 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-view {
            background-color: #3498db;
            color: white;
        }

        .btn-view:hover {
            background-color: #2980b9;
        }
    </style>
@endsection
