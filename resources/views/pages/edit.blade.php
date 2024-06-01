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

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">Edit Page</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pages.update', $page->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $page->title) }}" required autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="feature_image">Feature Image</label>
                            <input id="feature_image" type="file" class="form-control @error('feature_image') is-invalid @enderror" name="feature_image">

                            @if ($page->feature_image)
                                <img src="{{ asset('storage/' . $page->feature_image) }}" alt="{{ $page->title }}" style="max-width: 100px;">
                            @endif

                            @error('feature_image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content', $page->content) }}"></textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="reading_time">Reading Time (in minutes)</label>
                            <input id="reading_time" type="number" class="form-control @error('reading_time') is-invalid @enderror" name="reading_time" value="{{ old('reading_time', $page->reading_time) }}">

                            @error('reading_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group form-check">
                            <input type="hidden" name="enable_comment" value="0"> <!-- Hidden input -->
                            <input id="enable_comment" type="checkbox" class="form-check-input" name="enable_comment" value="1" {{ old('enable_comment', $page->enable_comment) ? 'checked' : '' }}>
                            <label for="enable_comment" class="form-check-label">Enable Comments</label>

                            @error('enable_comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description">{{ old('meta_description', $page->meta_description) }}"></textarea>

                            @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input id="slug" type="text" class="form-control @error('slug') is-invalid @enderror" name="slug" value="{{ old('slug', $page->slug) }}" required>

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Page</button>
                        <a href="{{ route('pages.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('pages.show', $page->slug) }}" class="btn btn-info" target="_blank">View Page</a>
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
