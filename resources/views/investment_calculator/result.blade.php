@extends('layouts.app')
@section('title', 'Investment Calculator Result')

@section('content')
<div class="container mt-5">
    <h2>Investment Calculator Result</h2>
    <div class="alert alert-success">
        <p>Estimated retirement savings: <strong>${{ number_format($future_value, 2) }}</strong></p>
    </div>
    <a href="{{ route('investment_calculator.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
