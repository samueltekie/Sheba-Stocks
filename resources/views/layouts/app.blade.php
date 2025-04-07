<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Market App</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 100px; /* Narrower sidebar */
            background: #1f2937; /* Darker background */
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 15px 0;
            color: #9ca3af;
            font-size: 20px;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar a:hover {
            background: #374151;
            color: #fff;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f9fafb;
        }

        .stock-card {
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .stock-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .stock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .stock-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
        }

        .stock-price {
            font-size: 1.25rem;
            font-weight: bold;
            color: #34d399; /* Tailwind green-400 */
        }

        .stock-details p {
            color: #4b5563;
        }

        .stock-graph img {
            margin-top: 15px;
            width: 100%;
            border-radius: 5px;
        }

        /* Navbar styles */
        .navbar {
    background: #154734; /* Deep Blue for navbar background */
    color: #f9fafb; /* Lighter text color */
    padding: 15px 30px;
    display: flex;
    align-items: center; /* Aligns items vertically */
    justify-content: flex-start; /* Aligns content to the left */
    gap: 15px; /* Adds space between logo and text */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding-left: 170px; /* Adjust this value to move the navbar content to the right */
}

.image {
    width: 40px;         /* Sets the width of the logo */
    height: auto;        /* Maintains aspect ratio */

}
h1 {
    font-size: 1.75rem;  /* Adjust font size for title */
    font-weight: bold;   /* Makes the title bold */
    margin: 0;           /* Removes default margin */
    color: #D4AF37;      /* Gold color for the title */
}


        .navbar h1 {
            font-size: 1.75rem;
            font-weight: bold;
        }

        .navbar a {
            color: #9ca3af;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #f9fafb;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                flex-direction: row;
                width: 100%;
                padding: 0;
                justify-content: space-around;
                box-shadow: none;
            }

            .sidebar a {
                padding: 10px 0;
                font-size: 16px;
            }
            
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <div class="navbar">
        <img src="/img/shebas.png" class="image">
        <h1>Sheba-Stocks</h1>
    </div>

    <!-- Layout with Sidebar and Main Content -->
    <div class="layout">
        <!-- Sidebar -->
        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
    </div>
</body>
</html>

