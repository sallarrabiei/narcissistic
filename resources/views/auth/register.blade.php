@extends('layouts.app_login')

@section('content')

<main class="form-signup w-100 m-auto">

<form method="POST" action="{{ route('register') }}">
    @csrf

        <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72">
        <h1 class="h3 mb-3 fw-bold">عضویت در سایت</h1>

        <div class="form-floating my-1">

            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            <label for="name">{{ __('نام‌') }}</label>
        </div>
        <div class="form-floating my-1">
            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}"  autocomplete="last_name">
            @error('last_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            <label for="last_name">{{ __('نام‌خانوادگی (اختیاری)') }}</label>
        </div>
        <div class="form-floating my-1">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            <label for="email">{{ __('نشانی ایمیل') }}</label>
        </div>
        <div class="form-floating my-1">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            <label for="password">{{ __('رمز عبور') }}</label>
        </div>
        <div class="form-floating my-1">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

            <label for="password-confirm">{{ __('تکرار رمز عبور') }}</label>
        </div>


        <button class="btn btn-primary w-100 py-2" type="submit">عضویت</button>
        <p class="mt-5 mb-3 text-body-secondary">© ۱۴۰۳ |           <span class="text-body-secondary text-center">تمام حقوق این وبسایت برای شرکت توسعه تجارت الکترونیک رسا محفوظ است.</span>
        </p>
</form>

</main>
@endsection
