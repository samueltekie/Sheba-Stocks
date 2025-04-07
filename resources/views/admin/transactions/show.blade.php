@extends('layouts.admin')

@section('content')
<h1>Transaction Details</h1>
<p><strong>ID:</strong> {{ $transaction->id }}</p>
<p><strong>User ID:</strong> {{ $transaction->user_id }}</p>
<p><strong>Type:</strong> {{ $transaction->type }}</p>
<p><strong>Amount:</strong> ${{ number_format($transaction->amount, 2) }}</p>
<p><strong>Details:</strong> {{ $transaction->details }}</p>
<p><strong>Date:</strong> {{ $transaction->created_at }}</p>
@endsection