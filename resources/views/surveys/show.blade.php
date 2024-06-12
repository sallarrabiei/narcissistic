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

                    <a href="{{ route('surveys.edit', $survey->slug) }}" class="btn btn-primary mb-3">Edit Survey</a>
                    <form action="{{ route('surveys.destroy', $survey->slug) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger mb-3" onclick="return confirm('Are you sure you want to delete this survey?')">Delete Survey</button>
                    </form>
                    <a href="{{ route('surveys.questions.create', $survey->slug) }}" class="btn btn-primary mb-3">Add Question</a>
                    {{-- <a href="{{ route('surveys.tags.index', $survey->id) }}" class="btn btn-secondary mt-3">Manage Tags</a> --}}
                    <a href="{{ route('groups.index', $survey->slug) }}" class="btn btn-primary mb-3">Manage Groups</a>

                    <ul class="list-group">
                        @foreach ($survey->questions as $question)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $question->text }}
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('surveys.questions.edit', ['survey' => $survey->slug, 'question' => $question->id]) }}">Edit Question</a>
                                    <form action="{{ route('questions.destroy', ['survey' => $survey->slug, 'question' => $question->id]) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this question?')">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
