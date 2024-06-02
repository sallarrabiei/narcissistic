@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $survey->title }} - Your Result</div>

                <div class="card-body">
                    <h5>Your Total Score: {{ $score }}</h5>
                    @php
                        $analysisText = '';
                        foreach ($analysisConditions as $condition) {
                            if ($score >= $condition['min'] && $score <= $condition['max']) {
                                $analysisText = $condition['text'];
                                break;
                            }
                        }
                    @endphp
                    <p>{{ $analysisText }}</p>
                    <p>Thank you for completing the survey.</p>

                    <hr>

                    <h5>Survey Analysis</h5>
                    <p>Total Participants: {{ $totalParticipants }}</p>
                    <p>Average Score: {{ number_format($averageScore, 2) }}</p>

                    <button id="share-twitter" class="btn btn-primary mt-3">Share on Twitter</button>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.getElementById('share-twitter').addEventListener('click', function() {
    var url = encodeURIComponent(window.location.href);
    var text = encodeURIComponent("I just completed the survey '{{ $survey->title }}' with a score of {{ $score }}.");
    var twitterUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
    window.open(twitterUrl, '_blank', 'width=500,height=300');
});

</script>
@endsection
