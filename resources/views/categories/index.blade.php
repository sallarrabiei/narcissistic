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
                <div class="card-header">Categories</div>

                <div class="card-body">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Create Category</a>

                    <ul class="list-group">
                        @foreach ($categories as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                    </form>
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
