@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $survey->title }}</div>

                <div class="card-body">
                    <p>{{ $survey->description }}</p>

                    @if(!isset($currentQuestion) && !isset($firstQuestion))
                        <form method="POST" action="{{ route('surveys.public.question', $survey->slug) }}">
                            @csrf
                            <input type="hidden" name="question_index" value="0">
                            <button type="submit" name="direction" value="start" class="btn btn-primary">Start Test</button>
                        </form>
                    @endif

                    @if(isset($firstQuestion) || isset($currentQuestion))
                        @php
                            $question = isset($firstQuestion) ? $firstQuestion : $currentQuestion;
                            $currentIndex = isset($firstQuestion) ? 0 : $currentIndex;
                        @endphp

                        <form method="POST" action="{{ route('surveys.public.question', $survey->slug) }}">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <input type="hidden" name="question_index" value="{{ $currentIndex }}">

                            <h5>{{ $question->text }}</h5>
                            @foreach ($question->options as $option)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="responses[{{ $question->id }}]" id="option_{{ $option->id }}" value="{{ $option->value }}">
                                    <label class="form-check-label" for="option_{{ $option->id }}">
                                        {{ $option->label }}
                                    </label>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-between mt-4">
                                @if ($currentIndex > 0)
                                    <button type="submit" name="direction" value="prev" class="btn btn-secondary">Previous Question</button>
                                @endif
                                @if ($currentIndex < count($survey->questions) - 1)
                                    <button type="submit" name="direction" value="next" class="btn btn-primary">Next Question</button>
                                @else
                                    <button type="submit" formaction="{{ route('surveys.submit', $survey->slug) }}" class="btn btn-success">Submit Test</button>
                                @endif
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
