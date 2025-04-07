@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Stock</h1>

    <form action="{{ route('admin.stocks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="symbol" class="form-label">Symbol</label>
            <input type="text" class="form-control" id="symbol" name="symbol" required>
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <input type="text" class="form-control" id="company" name="company" required>
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo (optional)</label>
            <input type="file" class="form-control" id="logo" name="logo">
        </div>
        <button type="submit" class="btn btn-success">Add Stock</button>
    </form>
</div>
@endsection
