@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $survey->title }}</div>

                <div class="card-body">
                    <h5>Your Score: {{ $score }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
