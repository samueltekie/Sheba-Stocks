@extends('layouts.admin')

@section('content')
<h1>Edit User</h1>
<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label for="name">Name:</label>
<input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>

<label for="email">Email:</label>
<input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required>
    
    <!-- Add any other fields needed -->

    <button type="submit">Update User</button>
</form>
@endsection