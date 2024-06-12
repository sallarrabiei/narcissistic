@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Groups in {{ $survey->title }}</div>

                <div class="card-body">
                    <a href="{{ route('groups.create', $survey) }}" class="btn btn-primary mb-3">Add Group</a>
                    <ul>
                        @foreach($groups as $group)
                            <li>{{ $group->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
