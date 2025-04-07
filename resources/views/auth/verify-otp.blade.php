@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg bg-white shadow-lg rounded-lg mt-10">
    <h2 class="text-3xl font-semibold text-center text-gray-800 mb-6">Verify Your Email</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded-lg mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('otp.verify') }}" method="POST" class="space-y-6">
        @csrf
        <div class="form-group">
            <label for="otp" class="block text-lg font-medium text-gray-700">Enter OTP</label>
            <input type="text" id="otp" name="otp" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-300">Verify OTP</button>
    </form>

    <form action="{{ route('otp.resend') }}" method="POST" class="mt-4 text-center">
        @csrf
        <button type="submit" class="text-blue-600 hover:underline text-lg">Resend OTP</button>
    </form>
</div>
@endsection
