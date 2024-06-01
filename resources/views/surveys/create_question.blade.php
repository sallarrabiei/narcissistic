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
                <div class="card-header">Add Question to Survey: {{ $survey->title }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('surveys.questions.store', $survey->slug) }}">
                        @csrf

                        <div class="form-group">
                            <label for="text">Question Text</label>
                            <input id="text" type="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{ old('text') }}" required autofocus>

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
                                    <option value="{{ $optionType->id }}">{{ $optionType->name }}</option>
                                @endforeach
                            </select>

                            @error('option_type_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Add Question</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
