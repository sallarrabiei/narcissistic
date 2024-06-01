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
                <div class="card-header">Edit Comment</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('comments.update', $comment->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="author">Name</label>
                            <input id="author" type="text" class="form-control @error('author') is-invalid @enderror" name="author" value="{{ old('author', $comment->author) }}" required>

                            @error('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Comment</label>
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" name="content" rows="3" required>{{ old('content', $comment->content) }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                <option value="pending" {{ $comment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $comment->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="spam" {{ $comment->status == 'spam' ? 'selected' : '' }}>Spam</option>
                            </select>

                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Comment</button>
                        <a href="{{ route('comments.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
