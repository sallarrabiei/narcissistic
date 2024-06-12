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
                <div class="card-header">Edit Question</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('questions.update', $question->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="text">Question Text</label>
                            <input id="text" type="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{ old('text', $question->text) }}" required autofocus>

                            @error('text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="option_type_id">Option Type</label>
                            <select id="option_type_id" class="form-control @error('option_type_id') is-invalid @enderror" name="option_type_id" required>
                                <option value="">Select Option Type</option>
                                @foreach ($optionTypes as $optionType)
                                    <option value="{{ $optionType->id }}" {{ $optionType->id == $question->option_type_id ? 'selected' : '' }}>{{ $optionType->name }}</option>
                                @endforeach
                            </select>

                            @error('option_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        @foreach($tags as $tag)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    id="tag{{ $tag->id }}" {{ in_array($tag->id, $question->tags->pluck('id')->toArray()) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tag{{ $tag->id }}">
                                    {{ $tag->name }}
                                </label>
                            </div>
                        @endforeach

                        <button type="submit" class="btn btn-primary">Update Question</button>
                        <a href="{{ route('surveys.show', $question->survey->slug) }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
