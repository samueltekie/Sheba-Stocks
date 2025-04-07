@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Stock</h1>

    <form action="{{ route('admin.stocks.update', $stock->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $stock->name }}" required>
        </div>
        <div class="mb-3">
            <label for="symbol" class="form-label">Symbol</label>
            <input type="text" class="form-control" id="symbol" name="symbol" value="{{ $stock->symbol }}" required>
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <input type="text" class="form-control" id="company" name="company" value="{{ $stock->company }}" required>
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo (optional)</label>
            <input type="file" class="form-control" id="logo" name="logo">
            @if($stock->logo)
                <img src="{{ asset('storage/' . $stock->logo) }}" alt="Logo" width="50">
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Update Stock</button>
    </form>
</div>
@endsection
