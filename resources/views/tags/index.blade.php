@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tags </div>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="card-body">
                    <a href="{{ route('tags.create') }}" class="btn btn-primary mb-3">Add Tag</a>
                    <ul>
                        @foreach($tags as $tag)
                            <li>{{ $tag->name }}
                                <form method="POST" action="{{ route('surveys.tags.destroy') }}">
                                    @csrf
                                    @method('DELETE')
                a                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
