@extends('layouts.admin')

@section('content')
<h1 style="color: #D4AF37;">Transaction Details for User {{ $transactions[0]->user_id }}</h1>

@if(session('error'))
    <div class="alert alert-danger" style="background-color: #e74c3c; color: white; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
        {{ session('error') }}
    </div>
@endif

<div class="table-container" style="background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="background-color: #0D3B66; color: #fff; padding: 12px; font-size: 1.1rem;">Type</th>
                <th style="background-color: #0D3B66; color: #fff; padding: 12px; font-size: 1.1rem;">Amount</th>
                <th style="background-color: #0D3B66; color: #fff; padding: 12px; font-size: 1.1rem;">Details</th>
                <th style="background-color: #0D3B66; color: #fff; padding: 12px; font-size: 1.1rem;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $transaction)
            <tr>
                <td style="padding: 12px; text-align: left;">{{ $transaction->type }}</td>
                <td style="padding: 12px; text-align: left;">${{ number_format($transaction->amount, 2) }}</td>
                <td style="padding: 12px; text-align: left;">{{ $transaction->details }}</td>
                <td style="padding: 12px; text-align: left;">{{ $transaction->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
