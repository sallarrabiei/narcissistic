@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Survey</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('surveys.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="short_description">Short Description</label>
                            <input id="short_description" type="text" class="form-control @error('short_description') is-invalid @enderror" name="short_description" value="{{ old('short_description') }}" required>

                            @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea name="meta_description" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="categories">Categories</label>
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="category{{ $category->id }}">
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug') }}">

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input id="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}">

                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="analysis_text">Survey Analysis Text</label>
                            <textarea name="analysis_text" class="form-control text-editor"></textarea>
                        </div>

                        <div id="conditions-container">
                            <h5>Analysis Conditions</h5>
                            <div class="form-group">
                                <label>Score Range</label>
                                <input type="number" name="conditions[0][min]" class="form-control" placeholder="Min">
                                <input type="number" name="conditions[0][max]" class="form-control" placeholder="Max">
                                <textarea name="conditions[0][text]" class="form-control" placeholder="Text for this range"></textarea>
                            </div>
                        </div>
                        <button type="button" id="add-condition" class="btn btn-secondary">Add Condition</button>

                        <button type="submit" class="btn btn-primary">Create Survey</button>
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
