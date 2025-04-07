<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

<!-- Optionally, include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Reset some basic styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #154734;
            color: #fff;
            padding-top: 40px;
            padding-left: 30px;
            transition: all 0.3s ease;
        }

        .admin-sidebar h2 {
            color: #ecf0f1;
            font-size: 1.8rem;
            margin-bottom: 30px;
        }

        .admin-sidebar ul {
            list-style-type: none;
        }

        .admin-sidebar ul li {
            margin-bottom: 20px;
        }

        .admin-sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .admin-sidebar ul li a:hover {
            background-color: #34495e;
        }

        .admin-sidebar ul li a i {
            margin-right: 15px;
            font-size: 1.3rem;
        }

        .admin-sidebar ul li a:active {
            background-color: #16a085;
        }

        /* Main content styles */
        .admin-main-content {
            margin-left: 250px;
            padding: 30px;
            width: 100%;
            background-color: #ecf0f1;
            transition: margin-left 0.3s ease;
        }

        /* Logout Confirmation */
        #logout-form {
            display: none;
        }

        /* Fixed top styles */
        .admin-container .admin-sidebar {
            top: 0;
            left: 0;
            position: fixed;
            height: 100%;
            z-index: 1000;
        }

        /* Add hover effect to menu icons */
        .admin-sidebar ul li a:hover i {
            color: #f39c12;
        }
        .image {
    width: 50px;          /* Sets the width of the logo */
    height: auto;         /* Maintains aspect ratio */
    display: flex;        /* Enables flexbox */
    justify-content: center; /* Centers the image horizontally */
    align-items: center;  /* Centers the image vertically */
    margin: 0 auto;       /* Ensures the container is centered if the image is a block element */
}

    </style>
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
    <img src="/img/shebas.png" class="image">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> User Management</a></li>
            <li><a href="{{ route('admin.stocks.index') }}"><i class="fas fa-chart-line"></i> Stock Management</a></li>
            <li><a href="{{ route('admin.transactions.index') }}"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
            <li><a href="#" onclick="confirmLogout(event)"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>

    <!-- Main Content -->
    <main class="admin-main-content">
        @yield('content')
    </main>
</div>

<script>
    function confirmLogout(event) {
        event.preventDefault();
        if (confirm("Are you sure you want to logout?")) {
            document.getElementById('logout-form').submit();
        }
    }
</script>

</body>
</html>
