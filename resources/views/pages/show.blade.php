@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $page->title }}</div>

                <div class="card-body">
                    @if ($page->feature_image)
                        <img src="{{ asset('storage/' . $page->feature_image) }}" alt="{{ $page->title }}" style="max-width: 100%;">
                    @endif
                    <div>{!! $page->content !!}</div>

                    @if ($page->enable_comment)
                        <h3>Comments</h3>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('comments.store', $page->slug) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="author">Name</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" required>
                                @error('author')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">Comment</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="3" required></textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                        @if ($page->comments->where('status', 'accepted')->count() > 0)
                            <h4>All Comments</h4>
                            @foreach ($page->comments->where('status', 'accepted') as $comment)
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h5>{{ $comment->author }}</h5>
                                        <p>{{ $comment->content }}</p>
                                        <p><small>{{ $comment->created_at->format('F d, Y \a\t h:i A') }}</small></p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No comments yet. Be the first one to write a comment!</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
