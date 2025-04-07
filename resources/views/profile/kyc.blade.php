@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload KYC Document</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('kyc.upload') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="document_type">Document Type</label>
        <select>
            <option>Select Type</option>
            <option>Passport</option>
            <option>National-ID</option>
        </select>
    </div><br>
    <div class="form-group">
        <label for="document">Upload Document</label>
        <input type="file" id="document" name="document" class="form-control" required>
    </div><br>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>
</div>
@endsection