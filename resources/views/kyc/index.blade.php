@extends('layouts.app')

@section('content')
<div class="container">
    <h1>KYC Documents</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($kycDocuments as $document)
        <div class="document">
            <p>Type: {{ $document->document_type }}</p>
            <p>Status: {{ $document->verified ? 'Verified' : 'Pending' }}</p>
            <a href="{{ asset('storage/' . $document->document_path) }}" target="_blank">View Document</a>

            @if(auth()->user()->isAdmin()) <!-- Example check for admin -->
                <form action="{{ route('kyc.verify', $document->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Verify</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection