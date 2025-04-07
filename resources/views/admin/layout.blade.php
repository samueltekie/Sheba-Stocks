<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}"> <!-- Add custom CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('admin.users.index') }}">User Management</a></li>
                <li><a href="{{ route('admin.stocks.index') }}">Stock Management</a></li>
                <li><a href="{{ route('admin.transactions.index') }}">Transactions</a></li>
                <li><a href="{{ route('logout') }}">Logout</a></li>
            </ul>
        </aside>
        <main class="admin-main-content">
            @yield('content')
        </main>
    </div>
</body>
</html>