@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <h5>Your Survey Results</h5>
                    @if ($results->isEmpty())
                        <p>You have not taken any surveys yet.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Survey</th>
                                    <th>Score</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                    <tr>
                                        <td>{{ $result->survey->title }}</td>
                                        <td>{{ $result->score }}</td>
                                        <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
