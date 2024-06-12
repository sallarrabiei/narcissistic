@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">نتایج {{ $survey->title }}</div>

                <div class="card-body">
                    {{-- <h5>Your Total Score: {{ $score }}</h5>
                    @php
                        $analysisText = '';
                        foreach ($analysisConditions as $condition) {
                            if ($score >= $condition['min'] && $score <= $condition['max']) {
                                $analysisText = $condition['text'];
                                break;
                            }
                        }
                    @endphp --}}
                    {{-- <h4> امتیازات شما: </h4> --}}
                    @if($averageScores)
                        <h3>جدول امتیاز شما:</h3>
                        <table class="table my-5">

                        @foreach($averageScores as $group => $averageScore)
                        <tr>
                            <td>{{ $group }}</td>
                            <td><b> {{ $averageScore }}</b></td>
                        </tr>
                        @endforeach
                        </table>
                    @endif
                    @if($analysisText)
                        <p>{!! $analysisText !!}</p>
                    @endif
                    <p  class="fs-5 text-body-secondary">ممنون از اینکه وقت گذاشتید و در این نظرسنجی شرکت کردید. هدف از این نظرسنجی قضاوت هیچ شخصی نیست، بلکه تنها به منظور آشنایی بیشتر شما با ویژگی‌های شخصیتی‌تان طراحی و اجرا شده است. امیدواریم این پرسشنامه به شما در شناخت بهتر خود و توسعه فردی کمک کند.

                    </p>

                    {{-- <hr> --}}

                    {{-- <h5>Survey Analysis</h5> --}}
                    {{-- <p>Total Participants: {{ $totalParticipants }}</p>
                    <p>Average Score: {{ number_format($averageScore, 2) }}</p> --}}

                    <button id="share-twitter" class="btn btn-primary mt-3">به دوستان خود در توییتر وبسایت ما را معرفی کنید.</button>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.getElementById('share-twitter').addEventListener('click', function() {
    var url = encodeURIComponent(window.location.href);
    var text = encodeURIComponent("من در  '{{ $survey->title }}'  شرکت @rasatarin کردم. شما هم شرکت کنید: www.narcissistic.ir {{ $score }}.");
    var twitterUrl = `https://twitter.com/intent/tweet?url=${url}&text=${text}`;
    window.open(twitterUrl, '_blank', 'width=500,height=300');
});

</script>
@endsection
