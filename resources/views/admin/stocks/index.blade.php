@extends('layouts.admin')

@section('content')

<!-- Main Content Section -->
<div class="p-6 bg-[#f4f6f9] min-h-screen">

    <!-- Page Title -->
    <h1 class="text-3xl font-bold text-[#0D3B66] mb-8">Manage Stock Symbols</h1>

    <!-- Add New Stock Symbol Form at the top -->
    <div class="mb-6">
        <form action="{{ route('admin.stocks.store') }}" method="POST" class="flex items-center space-x-4">
            @csrf
            <input type="text" name="symbol" class="p-3 border-2 border-[#D4AF37] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#D4AF37] text-lg" placeholder="Enter stock symbol" required>
            <button type="submit" class="bg-[#D4AF37] text-white px-6 py-3 rounded-lg text-lg hover:bg-[#0D3B66] transition duration-300 ease-in-out">
                Add Symbol
            </button>
        </form>
    </div>

    <!-- List of Stock Symbols -->
    @if(!empty($symbols))
        <ul class="space-y-4">
            @foreach($symbols as $symbol)
                <li class="bg-white shadow-md rounded-lg p-4 flex justify-between items-center">
                    <span class="text-xl font-semibold text-[#0D3B66]">{{ $symbol }}</span>
                    
                    <!-- Remove Symbol Button -->
                    <form action="{{ route('admin.stocks.destroy', $symbol) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-[#6B8E23] text-white px-4 py-2 rounded-lg text-sm hover:bg-[#D4AF37] transition duration-300 ease-in-out">
                            Remove
                        </button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500 mt-4">No symbols found.</p>
    @endif

</div>

@endsection
