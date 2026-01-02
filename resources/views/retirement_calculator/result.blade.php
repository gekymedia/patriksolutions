@extends('layouts.app')
@section('title', 'Retirement Calculator Result')

@section('content')
<div class="container mt-5">
    <h2>Retirement Calculator Result</h2>
    <div class="alert alert-success">
        <p>Estimated retirement savings: <strong>${{ number_format($future_value, 2) }}</strong></p>
    </div>
    <a href="{{ route('retirement_calculator.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
