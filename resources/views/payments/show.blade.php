@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment for {{ $survey->title }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('payment.process', $survey->id) }}">
                        @csrf

                        <p>To access this survey, you need to pay {{ $survey->price }}.</p>

                        <!-- Implement your payment form here -->

                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
