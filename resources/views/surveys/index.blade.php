@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Surveys</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('surveys.create') }}" class="btn btn-primary mb-3">Create Survey</a>

                    <ul class="list-group">
                        @foreach ($surveys as $survey)
                            <li class="list-group-item">
                                <a href="{{ route('surveys.show', $survey) }}">{{ $survey->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
