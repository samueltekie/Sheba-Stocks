@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">KYC Verification Dashboard</h1>

        <!-- KYC Status Section -->
        @if($documentsUploaded)
            <div class="bg-white shadow-lg rounded-lg p-8 max-w-4xl mx-auto">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">Your Documents Have Been Uploaded</h3>
                <p class="text-lg text-gray-600 mb-4">Your documents are currently under review by our team.</p>

                <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                    <h4 class="text-xl font-semibold text-gray-700">KYC Status: 
                        @if(session('Status') === 'approved')
                            <span class="text-green-500">Approved</span>
                        @elseif(session('Status') === 'rejected')
                            <span class="text-red-500">Rejected</span>
                        @elseif(session('Status') === 'not found')
                            <span class="text-yellow-500">No KYC Record Found</span>
                        @else
                            <span class="text-gray-500">{{ $kycStatus->status ?? 'Pending' }}</span>
                        @endif
                    </h4>
                    <p class="text-gray-600">Your submission is currently under review. Please check back later for updates.</p>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('profile.show') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white text-lg font-medium py-3 px-8 rounded-lg transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                        Go back to Profile
                    </a>
                </div>
            </div>
        @else
            <div class="bg-white shadow-lg rounded-lg p-8 max-w-4xl mx-auto">
                <h3 class="text-2xl font-semibold text-gray-800 mb-4">No Documents Uploaded Yet</h3>
                <p class="text-lg text-gray-600 mb-4">Please upload your KYC documents to proceed with the verification process.</p>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('kyc.step1') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white text-lg font-medium py-3 px-8 rounded-lg transition duration-300 ease-in-out shadow-md transform hover:scale-105">
                        Upload Documents
                    </a>
                </div>
            </div>
        @endif
    </div>
@endsection
