@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $survey->title }}</div>
Hi
                <div class="card-body">
                    <p>{{ $survey->description }}</p>

                    @if(!isset($currentQuestion) && !isset($firstQuestion))
                        <button id="start-test" class="btn btn-primary">Start Test</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#start-test').on('click', function() {
        var isAuthenticated = @json(Auth::check());

        if (isAuthenticated) {
            window.location.href = "{{ route('surveys.public.question', $survey->slug) }}";
        } else {
            window.location.href = "{{ route('login', ['intended_url' => route('surveys.public.question', $survey->slug)]) }}";
        }
    });
});
</script>
@endsection
