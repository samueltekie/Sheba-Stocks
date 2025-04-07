@extends('layouts.app')

@section('content')
@extends('layouts.nav')

<head>
    <!-- Import Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl">
        <h1 class="text-4xl font-bold text-center text-blue-600 mb-8">Stock Details: {{ $symbol }}</h1>

        <!-- Stock Chart -->
        <div class="flex justify-center mb-8">
            <canvas id="stockChart" class="rounded-lg border border-gray-300 shadow" width="800" height="400"></canvas>
        </div>

        <!-- Timeframe Buttons -->
        <div class="flex justify-center space-x-4 mb-8">
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition" onclick="loadChartData('1d')">1 Day</button>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition" onclick="loadChartData('1w')">1 Week</button>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition" onclick="loadChartData('1m')">1 Month</button>
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition" onclick="loadChartData('1y')">1 Year</button>
        </div>

        <!-- Technical Indicator Toggles -->
        <div class="flex justify-center space-x-8 mb-8">
            <label class="flex items-center text-lg">
                <input type="checkbox" id="toggleSMA" onclick="toggleSMA()" class="mr-2"> Show SMA
            </label>
            <label class="flex items-center text-lg">
                <input type="checkbox" id="toggleEMA" onclick="toggleEMA()" class="mr-2"> Show EMA
            </label>
            <label class="flex items-center text-lg">
                <input type="checkbox" id="toggleRSI" onclick="toggleRSI()" class="mr-2"> Show RSI
            </label>
        </div>

       <!-- Stock Information -->
<div class="bg-gray-100 shadow-lg rounded-lg p-8 text-center mb-8 max-w-lg mx-auto">
    <h2 class="text-3xl font-semibold mb-4">
        Current Price: <span class="text-green-600">${{ $price }}</span>
    </h2>
    <div class="flex justify-center space-x-6 mb-4">
        <p class="text-lg font-medium">
            Day High: <span class="text-green-500">${{ $stock['high'] }}</span>
        </p>
        <p class="text-lg font-medium">
            Day Low: <span class="text-red-500">${{ $stock['low'] }}</span>
        </p>
    </div>
    <p class="text-lg text-gray-600">
        Open: <span class="text-blue-600">${{ $stock['open'] }}</span>
    </p>
</div>

        <!-- Buy Stock Form -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-8">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded mb-8">
            {{ session('error') }}
        </div>
        @endif

        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold mb-4">Buy Stock: {{ $symbol }}</h2>
            <form action="{{ route('stocks.buy') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="symbol" value="{{ $symbol }}">
                <div class="flex justify-center">
                    <input type="number" id="quantity" name="quantity" min="1" placeholder="Quantity" required class="border border-gray-300 rounded-lg p-3 w-40 text-center focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                    Buy <i class="fas fa-shopping-cart"></i>
                </button>
            </form>
            <p id="totalCost" class="text-xl mt-4 text-gray-700"></p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

<script>
    let stockChart;
    let stockData = {};

    window.onload = () => {
        loadChartData('1d');
        fetchNews();
        fetchAnalystRatings('{{ $symbol }}');
    };

    function loadChartData(timeframe) {
        const staticData = {
            dates: ["2024-01-01", "2024-01-02", "2024-01-03"],
            prices: [150, 152, 148]
        };
        stockData = staticData;
        updateChart();
    }

    function updateChart() {
        const ctx = document.getElementById('stockChart').getContext('2d');
        if (stockChart) {
            stockChart.destroy();
        }

        stockChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: stockData.dates,
                datasets: [{
                    label: 'Stock Price',
                    data: stockData.prices,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    }

    function fetchNews() {
        fetch('https://newsapi.org/v2/everything?q=stock&apiKey=YOUR_API_KEY')
            .then(response => response.json())
            .then(data => {
                const newsList = document.getElementById('newsList');
                newsList.innerHTML = '';
                data.articles.forEach(article => {
                    const li = document.createElement('li');
                    li.textContent = article.title;
                    newsList.appendChild(li);
                });
            })
            .catch(error => console.error('Error fetching news:', error));
    }

    const price = {{ $price }};
    const quantityInput = document.getElementById('quantity');
    const totalCostElement = document.getElementById('totalCost');

    quantityInput.addEventListener('input', () => {
        const quantity = quantityInput.value;
        totalCostElement.textContent = `Total Cost: $${(price * quantity).toFixed(2)}`;
    });
</script>
@endsection
