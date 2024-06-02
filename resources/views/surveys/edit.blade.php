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
                <div class="card-header">Edit Survey</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('surveys.update', $survey->slug) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $survey->title) }}" required autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <input id="short_description" type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description" value="{{ old('short_description', $survey->short_description) }}" required>

                            @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description', $survey->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" class="form-control">{{ $survey->meta_description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="categories">Categories</label>
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}" {{ in_array($category->id, $survey->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $survey->slug) }}" required>

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input id="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $survey->price) }}">

                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="analysis_text">Survey Analysis Text</label>
                            <textarea name="analysis_text" class="form-control text-editor">{{ $survey->analysis_text }}</textarea>
                        </div>

                        <div id="conditions-container">
                            <h5>Analysis Conditions</h5>
                            @if(is_array($survey->analysis_conditions))
                                @foreach($survey->analysis_conditions as $index => $condition)
                                    <div class="form-group">
                                        <label>Score Range</label>
                                        <input type="number" name="conditions[{{ $index }}][min]" class="form-control" value="{{ $condition['min'] }}" placeholder="Min">
                                        <input type="number" name="conditions[{{ $index }}][max]" class="form-control" value="{{ $condition['max'] }}" placeholder="Max">
                                        <textarea name="conditions[{{ $index }}][text]" class="form-control" placeholder="Text for this range">{{ $condition['text'] }}</textarea>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" id="add-condition" class="btn btn-secondary">Add Condition</button>

                        <button type="submit" class="btn btn-primary">Update Survey</button>
                        <a href="{{ route('surveys.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('surveys.public.start', $survey->slug) }}" class="btn btn-info" target="_blank">View Survey</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
    CKEDITOR.replace('analysis_text');

</script>
<script>
    document.getElementById('add-condition').addEventListener('click', function() {
        var container = document.getElementById('conditions-container');
        var index = container.children.length;
        var div = document.createElement('div');
        div.classList.add('form-group');
        div.innerHTML = `
            <label>Score Range</label>
            <input type="number" name="conditions[${index}][min]" class="form-control" placeholder="Min">
            <input type="number" name="conditions[${index}][max]" class="form-control" placeholder="Max">
            <textarea name="conditions[${index}][text]" class="form-control" placeholder="Text for this range"></textarea>
        `;
        container.appendChild(div);
    });
    </script>
@endsection
