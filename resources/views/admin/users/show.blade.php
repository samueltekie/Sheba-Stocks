@extends('layouts.admin')

@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <h1>User Details</h1>
    </div>

    <!-- User Details Section -->
    <div class="user-details">
        <div class="user-info">
            <p><strong>ID:</strong> <span>{{ $user->id }}</span></p>
            <p><strong>Name:</strong> <span>{{ $user->name }}</span></p>
            <p><strong>Email:</strong> <span>{{ $user->email }}</span></p>
        </div>

        <!-- KYC Status Section -->
        <div class="kyc-status">
            <p><strong>KYC Status:</strong>
                @if(session('Status') === 'approved')
                    <span class="status-approved">Approved</span>
                @elseif(session('Status') === 'rejected')
                    <span class="status-rejected">Rejected</span>
                @elseif(session('Status') === 'not found')
                    <span class="status-pending">No KYC record found</span>
                @else
                    <span class="status-{{ strtolower($kycStatus->status ?? 'not_verified') }}">
                        {{ $kycStatus->status ?? 'Not Verified' }}
                    </span>
                @endif
            </p>
        </div>

        <!-- Documents Section -->
        <div class="documents-section">
            <h3>Submitted Documents</h3>
            @if($documents && $documents->count() > 0)
                <div class="documents-row">
                    @foreach($documents as $document)
                        <div class="document-item" onclick="openModal('{{ asset('storage/' . $document->document_path) }}')">
                            <div class="document-header">
                                <p><strong>Document Type:</strong> {{ $document->document_type }}</p>
                            </div>

                            <!-- Display Document Image -->
                            @if($document->document_path)
                                <div class="document-image">
                                    <img src="{{ asset('storage/' . $document->document_path) }}" alt="Document Image" class="doc-img">
                                </div>
                            @else
                                <p>No Document Image Available</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <p>No Documents Submitted</p>
            @endif
        </div>

        <!-- KYC Actions -->
        <div class="kyc-actions">
            <form action="{{ route('admin.users.approveKyc', $user->id) }}" method="POST" class="kyc-form">
                @csrf
                <button type="submit" class="btn-approve">Approve KYC</button>
            </form>
            <form action="{{ route('admin.users.rejectKyc', $user->id) }}" method="POST" class="kyc-form">
                @csrf
                <button type="submit" class="btn-reject">Reject KYC</button>
            </form>
        </div>
    </div>

    <!-- Fullscreen Modal -->
    <div id="documentModal" class="modal">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="Document Image" class="modal-content">
    </div>

    <!-- Custom Styling -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Page Title */
        .page-title {
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(45deg, #1c6e6a, #0f4b3b); /* Green Gradient */
            padding: 20px;
            border-radius: 10px;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .page-title h1 {
            font-size: 2.5rem;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* User Details Section */
        .user-details {
            background-color: #ffffff; 
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            margin: 30px auto;
        }

        .user-info {
            margin-bottom: 30px;
        }

        .user-info p {
            font-size: 1.2rem;
            color: #333; /* Darker text for better contrast */
        }

        .user-info span {
            font-weight: 500;
            color: #1c6e6a; /* Green */
        }

        /* KYC Status Section */
        .kyc-status p {
            font-size: 1.2rem;
            font-weight: 500;
            color: #333;
        }

        .status-approved {
            color: #fff;
            background-color: #1c6e6a;
            padding: 5px 15px;
            border-radius: 25px;
        }

        .status-rejected {
            color: #fff;
            background-color: #e74c3c;
            padding: 5px 15px;
            border-radius: 25px;
        }

        .status-pending {
            color: #fff;
            background-color: #f39c12;
            padding: 5px 15px;
            border-radius: 25px;
        }

        .status-not_verified {
            color: #fff;
            background-color: #95a5a6;
            padding: 5px 15px;
            border-radius: 25px;
        }

        /* Documents Section */
        .documents-section {
            margin-top: 40px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .documents-section h3 {
            font-size: 1.8rem;
            color: #1c6e6a;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .documents-row {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px 0;
        }

        .document-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 220px;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .document-item:hover {
            transform: scale(1.05);
        }

        .document-header p {
            font-size: 1.1rem;
            color: #333;
            font-weight: 600;
        }

        .document-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            border: 2px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        /* KYC Buttons */
        .btn-approve, .btn-reject {
            padding: 12px 25px;
            font-size: 1.1rem;
            font-weight: bold;
            color: white;
            background-color: #1c6e6a; 
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .btn-approve:hover {
            background-color: #16a085;
            transform: translateY(-3px);
        }

        .btn-reject {
            background-color: #e74c3c;
        }

        .btn-reject:hover {
            background-color: #c0392b;
            transform: translateY(-3px);
        }

        .kyc-form {
            display: inline-block;
            margin: 0 10px;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 10px;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fff;
            font-size: 3rem;
            cursor: pointer;
        }
    </style>

    <script>
        // Function to open the modal with the clicked document
        function openModal(imageSrc) {
            var modal = document.getElementById("documentModal");
            var modalImage = document.getElementById("modalImage");
            modal.style.display = "flex";
            modalImage.src = imageSrc;
        }

        // Function to close the modal
        function closeModal() {
            var modal = document.getElementById("documentModal");
            modal.style.display = "none";
        }
    </script>
@endsection
