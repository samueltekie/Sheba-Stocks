@extends('layouts.app')
@extends('layouts.nav')

@section('content')
<div class="main-content flex">
    
    <!-- Content Section -->
    <div class="content flex-1 ml-64 p-10 bg-gray-100 min-h-screen">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert bg-green-100 text-green-800 p-4 mb-6 rounded-lg shadow-md">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert bg-red-100 text-red-800 p-4 mb-6 rounded-lg shadow-md">{{ session('error') }}</div>
        @endif

        <!-- Profile Section -->
        <div class="profile-card bg-white rounded-lg shadow-lg p-8 flex items-center space-x-6 mb-10">
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-24 h-24 rounded-full object-cover border-4 border-gray-300">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h2>
                <p class="text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Stock List Header -->
        <h1 class="text-4xl font-extrabold text-gray-900 mb-8">Stock List</h1>

        <!-- Stock Cards Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach ($stocksData as $stock)
                <div class="stock-card bg-white rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-3 hover:scale-105">
                    <div class="p-6">
                        <!-- Stock Header -->
                        <div class="stock-header flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold text-gray-800">{{ $stock['symbol'] }}</h2>
                            <span class="stock-price text-2xl font-bold text-green-600">
                                ${{ is_numeric($stock['price']) ? number_format(floatval($stock['price']), 2) : 'N/A' }}
                            </span>
                        </div>

                        <!-- Stock Details -->
                        <a href="{{ route('stocks.show', ['symbol' => $stock['symbol']]) }}" class="block">
                            <p class="mb-1"><strong>High:</strong> ${{ is_numeric($stock['high']) ? number_format(floatval($stock['high']), 2) : 'N/A' }}</p>
                            <p class="mb-1"><strong>Low:</strong> ${{ is_numeric($stock['low']) ? number_format(floatval($stock['low']), 2) : 'N/A' }}</p>
                            <p class="mb-1"><strong>Open:</strong> ${{ is_numeric($stock['open']) ? number_format(floatval($stock['open']), 2) : 'N/A' }}</p>
                        </a>

                        <!-- Stock Graph -->
                        <div class="stock-graph">
                            <img src="{{ asset('img/' . strtolower($stock['symbol']) . '.png') }}" alt="Stock Graph for {{ $stock['symbol'] }}" class="w-full h-40 object-cover rounded-lg">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
