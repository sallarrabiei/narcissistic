@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center  mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $survey->title }}</div>

                <div class="card-body">
                    @if(isset($currentQuestion))
                        @php
                            $question = $currentQuestion;
                        @endphp

                        <form method="{{ $currentIndex < count($survey->questions) - 1 ? 'GET' : 'POST' }}" action="{{ $currentIndex < count($survey->questions) - 1 ? route('surveys.public.question', $survey->slug) : route('surveys.submit', $survey->slug) }}">
                            @csrf
                            <input type="hidden" name="index" value="{{ $currentIndex + 1 }}">

                            @foreach ($responses as $questionId => $response)
                                <input type="hidden" name="responses[{{ $questionId }}]" value="{{ $response }}">
                            @endforeach

                            <h5>{{ $question->text }}</h5>
                            @foreach ($question->options as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="responses[{{ $question->id }}]" id="option_{{ $option->id }}" value="{{ $option->value }}" {{ isset($responses[$question->id]) && $responses[$question->id] == $option->value ? 'checked' : '' }}>
                                    <label class="form-check-label" for="option_{{ $option->id }}">
                                        {{ $option->label }}
                                    </label>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-4">
                                {{-- @if ($currentIndex > 0)
                                    <a href="{{ route('surveys.public.question', ['slug' => $survey->slug, 'index' => $currentIndex - 1]) }}"
                                       class="btn btn-secondary"
                                       onclick="event.preventDefault(); this.closest('form').submit();">Previous Question</a>
                                @endif --}}
                                @if ($currentIndex < count($survey->questions) - 1)
                                    <button type="submit" class="btn btn-primary" id="next-button" disabled>Next Question</button>
                                @else
                                    <button type="submit" class="btn btn-success" id="next-button" disabled>Submit</button>
                                @endif
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    function updateNextButtonState() {
        if ($('input[name="responses[{{ $question->id }}]"]:checked').length > 0) {
            $('#next-button').prop('disabled', false);
        } else {
            $('#next-button').prop('disabled', true);
        }
    }

    $('input[name="responses[{{ $question->id }}]"]').on('change', function() {
        updateNextButtonState();
    });

    // Initialize the state of the next button when the page loads
    updateNextButtonState();
});
</script>
@endsection
