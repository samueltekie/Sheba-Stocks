@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Stock Management</h1>

    <a href="{{ route('admin.stocks.create') }}" class="btn btn-primary mb-3">Add Stock</a>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Symbol</th>
                <th>Company</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stocks as $stock)
            <tr>
                <td>{{ $stock->name }}</td>
                <td>{{ $stock->symbol }}</td>
                <td>{{ $stock->company }}</td>
                <td><img src="{{ asset('storage/' . $stock->logo) }}" alt="{{ $stock->name }}" style="width: 50px;"></td>
                <td>
                    <a href="{{ route('admin.stocks.edit', $stock->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('admin.stocks.delete', $stock->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $stocks->links() }}
</div>
@endsection