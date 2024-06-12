@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pricing-header p-3 pb-md-4 mx-auto mt-5 ">
        <h1 class="display-4 fw-normal text-body-emphasis fw-bold mb-5">{{ $survey->title }}</h1>
        <p class="fs-5 text-body-secondary mt-2">
            {!! $survey->description !!}
        </p>
    </div>
    @if(!isset($currentQuestion) && !isset($firstQuestion))
        <button id="start-test" class="btn btn-lg btn-outline-dark mx-auto w-100">شروع</button>
    @endif

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
