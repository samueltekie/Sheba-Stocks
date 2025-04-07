@extends('layouts.app')
@extends('layouts.nav')
@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">KYC - Step 1: Select Document Type</h1>
    
    <!-- Form Container -->
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md mx-auto">
        <form action="{{ route('kyc.step1') }}" method="POST">
            @csrf
            
            <!-- Document Type Select -->
            <div class="mb-6">
                <label for="document_type" class="block text-lg font-medium text-gray-700 mb-2">Select Document Type</label>
                <select name="document_type" id="document_type" class="form-select block w-full p-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                    <option value="ID">ID Card</option>
                    <option value="passport">Passport</option>
                    <option value="address_proof">National ID</option>
                </select>
            </div>
            
            <!-- Next Button -->
            <button type="submit" class="button1">
                Next
            </button>
        </form>
    </div>
</div>
@endsection
<style>
    .button1 {
    background-color: #154734; /* Dark green background */
    color: #fff; /* White text */
    padding: 12px 24px; /* Vertical and horizontal padding */
    font-size: 16px; /* Font size */
    font-weight: bold; /* Bold text */
    border-radius: 30px; /* Rounded corners */
    border: none; /* Remove default border */
    text-transform: uppercase; /* Uppercase text */
    cursor: pointer; /* Pointer cursor on hover */
    transition: all 0.3s ease; /* Smooth transition */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Subtle shadow for depth */
}

.button1:hover {
    background-color: #0f3d2d; /* Darker green on hover */
    transform: scale(1.05); /* Slight scale effect */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Stronger shadow on hover */
}

.button1:focus {
    outline: none; /* Remove default outline */
    box-shadow: 0 0 5px 2px rgba(20, 140, 60, 0.6); /* Green glow on focus */
}

.button1:active {
    background-color: #0a2e1c; /* Even darker green on click */
    transform: scale(1.02); /* Slight scale effect when clicked */
}

</style>
