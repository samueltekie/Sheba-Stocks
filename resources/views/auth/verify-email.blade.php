@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-lg bg-white shadow-lg rounded-lg mt-10">
    <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Email Verification Required</h1>
    <p class="text-lg text-gray-600 text-center mb-6">Before accessing this page, please verify your email address.</p>

    @if (session('status') == 'verification-link-sent')
        <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6">
            A new verification link has been sent to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}" class="text-center">
        @csrf
        <button type="submit" class="py-3 px-6 bg-blue-600 text-white rounded-lg text-lg font-semibold hover:bg-blue-700 transition duration-300">Resend Verification Email</button>
    </form>
</div>
@endsection
