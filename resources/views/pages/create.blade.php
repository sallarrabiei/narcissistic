@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create Page</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('pages.store') }}" enctype="multipart/form-data">
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
                            <label for="feature_image">Feature Image</label>
                            <input id="feature_image" type="file" class="form-control @error('feature_image') is-invalid @enderror" name="feature_image">

                            @error('feature_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content') }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="reading_time">Reading Time (in minutes)</label>
                            <input id="reading_time" type="number" class="form-control @error('reading_time') is-invalid @enderror" name="reading_time" value="{{ old('reading_time') }}">

                            @error('reading_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check">
                            <input id="enable_comment" type="checkbox" class="form-check-input" name="enable_comment" {{ old('enable_comment') ? 'checked' : '' }}>
                            <label for="enable_comment" class="form-check-label">Enable Comments</label>

                            @error('enable_comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{{ old('meta_description') }}</textarea>

                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

                        <button type="submit" class="btn btn-primary">Create Page</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('content');
</script>
@endsection
