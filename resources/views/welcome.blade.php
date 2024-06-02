@extends('layouts.app')

@section('content')
<div class="pricing-header p-3 pb-md-4 mx-auto mt-5 text-center">
    <h1 class="display-4 fw-normal text-body-emphasis fw-bold mb-5">خودشیفتگی</h1>
    <p class="fs-5 text-body-secondary mt-2">
        با ارائه تست‌های روانشناسی معتبر و علمی به شما کمک می‌کنیم تا میزان خودشیفتگی خود را به صورت دقیق و بدون هیچگونه قضاوت یا ناراحتی ارزیابی کنید. هدف ما این است که به شما در شناخت بهتر خود و بهبود روابط بین فردی‌تان کمک کنیم. همه ارزیابی‌ها با احترام کامل به حریم خصوصی شما انجام می‌شود تا تجربه‌ای مثبت و آموزنده داشته باشید.
    </p>
    <p class="fs-5 text-body-secondary">
        برای شرکت در تست‌های روانشناسی وبسایت خودشیفتگی، لطفاً ابتدا در سایت ثبت‌نام کنید. در فرآیند ثبت‌نام، تنها آدرس ایمیل و نام شما دریافت می‌شود، نام خانوادگی اختیاری می‌باشد. ما به هیچ اطلاعات اضافی نیاز نداریم و از این اطلاعات نیز صرفاً برای ارسال هدایای عضویت و ارتباطات ضروری از جمله اعلام اسامی برنده‌ قرعه‌کشی استفاده خواهیم کرد. این اطمینان را به شما می‌دهیم که حریم خصوصی شما کاملاً محترم شمرده خواهد شد.
    </p>
</div>
<!--tests -->
<div class="row row-cols-1 row-cols-md-3 mb-3 text-center border-top pt-3">
    @foreach ($surveys as $survey)
        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm">

                <div class="card-header py-3">
                    <h4 class="my-0 fw-normal fs-5">{{ $survey->price == 0 ? 'شرکت در این آزمون رایگان است.' : 'تومان' . $survey->price }}</h4>
                </div>

                <div class="card-body">
                    <h2 class="card-title pricing-card-title">{{ $survey->title }}</h2>
                    <p>{{ $survey->short_description }}</p>
                    <a href="{{ route('surveys.public.start', $survey->slug) }}" class="w-100 btn btn-lg btn-outline-dark">
                        شرکت در آزمون
                    </a>
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection
