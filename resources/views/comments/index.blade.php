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
                <div class="card-header">Comments</div>

                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($comments as $comment)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $comment->author }}</strong>
                                    <p>{{ $comment->content }}</p>
                                    <small>{{ $comment->status }}</small>
                                </div>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this comment?')">Delete</button>
                                    </form>
                                    @if ($comment->status == 'pending')
                                        <form action="{{ route('comments.accept', $comment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Are you sure you want to accept this comment?')">Accept</button>
                                        </form>
                                        <form action="{{ route('comments.spam', $comment->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Are you sure you want to mark this comment as spam?')">Spam</button>
                                        </form>
                                    @endif
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
