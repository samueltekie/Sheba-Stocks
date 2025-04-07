@extends('layouts.app')

@section('content')

<!-- Registration Form Container -->
<div class="flex justify-center items-center min-h-screen bg-gray-50 pt-16">
    <div class="bg-white shadow-xl rounded-lg p-10 max-w-xl w-full mx-4 transition-transform duration-500 transform hover:scale-105">
        
        <!-- Tabs for Register and Log In -->
        <div class="flex mb-8 border-b-2 border-gray-200">
            <button class="w-1/2 py-2 text-center font-semibold text-green-600 border-b-2 border-green-500">Register</button>
            <a href="{{ route('login') }}" class="w-1/2 py-2 text-center font-semibold text-gray-400 hover:text-green-500 transition duration-200">Log In</a>
        </div>

        <!-- Form Heading -->
        <h2 class="text-4xl font-extrabold text-center mb-8 text-gray-700">Create Your Account</h2>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Full Name -->
            <div class="mb-6">
                <input type="text" name="name" placeholder="Full Name *" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
                @error('name')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-6">
                <input type="email" name="email" placeholder="Email Address *" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
                @error('email')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Number -->
            <div class="mb-6">
                <input type="tel" name="phone" placeholder="Phone Number *" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
            </div>

            <!-- Profile Picture -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Profile Picture</label>
                <input type="file" name="profile_picture" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" accept="image/*">
            </div>

            <!-- Address -->
            <div class="mb-6">
                <input type="text" name="address" placeholder="Residential Address *" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
                @error('address')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <input type="password" name="password" placeholder="Password *" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
                @error('password')
                    <span class="text-sm text-red-600">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-8">
                <input type="password" name="password_confirmation" placeholder="Confirm Password *" class="w-full px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500" required>
            </div>

            <!-- Terms and Agreement -->
            <div class="flex items-center mb-8">
                <input type="checkbox" id="terms" class="mr-2 focus:outline-none focus:ring-green-500" required>
                <label for="terms" class="text-gray-600">
                    I accept the 
                    <a href="#" onclick="openModal(event)" class="text-green-500 hover:underline">Terms and Conditions</a>.
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-lg transition duration-300 transform hover:scale-105">
                Register
            </button>
        </form>

        <!-- Already Registered -->
        <p class="text-center mt-8 text-gray-500">Already have an account? 
            <a href="{{ route('login') }}" class="text-green-500 hover:underline">Log in here</a>
        </p>
    </div>
</div>

<!-- Terms Modal -->
<div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center z-50">
    <div class="bg-white p-8 rounded-lg max-w-lg w-full overflow-hidden">
        <h3 class="text-2xl font-bold mb-4">Terms and Conditions</h3>
        
        <!-- Terms Content (Scrollable) -->
        <div class="overflow-y-auto max-h-96">
            <p class="mb-4">
                Welcome to our platform. By registering an account, you agree to comply with and be bound by the following terms and conditions. Please review these terms carefully before using our services.
            </p>

            <h4 class="text-lg font-semibold mb-2">1. Account Registration</h4>
            <p class="mb-4">
                You must provide accurate and complete information during the registration process. It is your responsibility to maintain the confidentiality of your account and password. You agree to accept responsibility for all activities that occur under your account.
            </p>

            <h4 class="text-lg font-semibold mb-2">2. Privacy Policy</h4>
            <p class="mb-4">
                We value your privacy. All personal information you provide will be handled in accordance with our <a href="#" class="text-green-500 hover:underline">Privacy Policy</a>. Your data will not be shared with third parties without your consent.
            </p>

            <h4 class="text-lg font-semibold mb-2">3. User Conduct</h4>
            <p class="mb-4">
                You agree to use our services only for lawful purposes. You are prohibited from using the platform to engage in any activity that is harmful, offensive, or otherwise objectionable, including but not limited to posting defamatory, abusive, or infringing content.
            </p>

            <h4 class="text-lg font-semibold mb-2">4. Limitation of Liability</h4>
            <p class="mb-4">
                We are not responsible for any damages or losses that may result from your use of our platform. Our platform is provided on an "as-is" basis, and we make no warranties or guarantees regarding its availability, accuracy, or reliability.
            </p>

            <h4 class="text-lg font-semibold mb-2">5. Termination</h4>
            <p class="mb-4">
                We reserve the right to terminate your account at any time, without notice, for conduct that we believe violates these terms, is harmful to other users, or may cause damage to our platform.
            </p>

            <h4 class="text-lg font-semibold mb-2">6. Governing Law</h4>
            <p class="mb-6">
                These terms are governed by and construed in accordance with the laws of your country. Any disputes arising out of or related to these terms shall be resolved exclusively in the courts of your jurisdiction.
            </p>
        </div>

        <button onclick="closeModal()" class="bg-green-500 hover:bg-green-600 text-white py-3 px-5 rounded-lg">Close</button>
    </div>
</div>


<!-- JavaScript for Modal -->
<script>
    function openModal(event) {
        event.preventDefault();
        document.getElementById("termsModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("termsModal").classList.add("hidden");
    }
</script>

@endsection
