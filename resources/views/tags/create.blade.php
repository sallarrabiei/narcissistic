@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Tag</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('tags.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Tag Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Add Tag</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
