@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Add Group to {{ $survey->title }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('groups.store', $survey) }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Group Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Add Group</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
