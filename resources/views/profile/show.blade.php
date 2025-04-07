@extends('layouts.app')
@extends('layouts.nav')

@section('content')
<div class="main-content">
    <!-- Profile Section -->
    <div class="max-w-4xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="flex flex-col md:flex-row items-center p-8 bg-gray-800 text-white">
            <div class="flex-shrink-0">
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="w-32 h-32 rounded-full shadow-md border-4 border-gray-700">
            </div>
            <div class="mt-4 md:mt-0 md:ml-6">
                <h2 class="text-3xl font-semibold">{{ $user->name }}</h2>
                <p class="text-gray-300">{{ $user->email }}</p>
                <p class="mt-2 text-sm text-gray-400">Member since {{ $user->created_at->format('M Y') }}</p>
                <button onclick="confirmLogout(event)" class="mt-4 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded transition duration-300">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </div>

        <!-- Success and Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 mt-4 mx-4 rounded">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-4 mt-4 mx-4 rounded">{{ session('error') }}</div>
        @endif

        <!-- Profile Update Form -->
        <div class="p-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-700">Update Your Profile</h1>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Username</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" id="phone" name="phone" value="{{ $user->phone }}" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ $user->date_of_birth }}" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        <input type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full p-2 border border-gray-300 rounded">
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="mt-3 w-32 h-32 rounded shadow-lg">
                        @endif
                    </div>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded mt-6">Update Profile</button>
            </form>
        </div>
    </div>

    <!-- KYC Upload Section -->
    <div class="max-w-4xl mx-auto mt-8 bg-white shadow-lg rounded-lg p-8">
        <a href="{{ route('kyc.step1') }}" class="flex items-center text-blue-500 hover:text-blue-700 transition">
            <i class="fas fa-file-upload mr-3"></i> Upload KYC Document
        </a>
    </div>

    <!-- Account Deactivation/Deletion Section -->
    <div class="max-w-4xl mx-auto mt-8 bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-xl font-bold text-gray-700 mb-4">Account Settings</h2>
        <div class="flex space-x-4">
            <form action="{{ route('account.deactivate') }}" method="POST">
                @csrf
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Deactivate Account</button>
            </form>
            <form action="{{ route('account.delete') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Delete Account</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Logout Confirmation -->
<script>
    function confirmLogout(event) {
        event.preventDefault(); // Prevent the default link behavior
        if (confirm("Are you sure you want to logout?")) {
            document.getElementById('logout-form').submit(); // Submit the form if confirmed
        }
    }
</script>

@endsection
