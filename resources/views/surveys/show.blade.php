@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">{{ $survey->title }}</div>

                <div class="card-body">
                    <p>{{ $survey->description }}</p>

                    <a href="{{ route('surveys.questions.create', $survey) }}" class="btn btn-primary mb-3">Add Question</a>

                    <ul class="list-group">
                        @foreach ($survey->questions as $question)
                            <li class="list-group-item">
                                {{ $question->text }}
                                <ul>
                                    @foreach ($question->options as $option)
                                        <li>{{ $option->label }} (Value: {{ $option->value }})</li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
