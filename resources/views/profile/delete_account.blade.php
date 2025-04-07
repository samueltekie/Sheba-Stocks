<!-- delete_account.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Account Settings</h1>

    <form action="{{ route('account.deactivate') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-warning">Deactivate Account</button>
    </form>

    <form action="{{ route('account.delete') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Delete Account</button>
    </form>
</div>
@endsection