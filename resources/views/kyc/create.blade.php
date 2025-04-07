@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Upload KYC Document</h1>
    <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="document_type">Document Type</label>
            <input type="text" id="document_type" name="document_type" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="document">Upload Document</label>
            <input type="file" id="document" name="document" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
@endsection