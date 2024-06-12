@extends('layouts.app_login')

@section('content')
<main class="form-signin w-100 m-auto">

    <form method="POST" action="{{ route('login') }}">
        @csrf

            <img class="mb-4" src="{{ asset('images/logo.png') }}" alt="" width="72">
            <h1 class="h3 mb-3 fw-bold">ورود به حساب کاربری</h1>

            <div class="form-floating">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label  for="email">{{ __('نشانی ایمیل') }}</label>
            </div>
            <div class="form-floating">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <label for="password">{{ __('رمز عبور') }}</label>
            </div>

            <div class="form-check text-start my-3">
                <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                مرا به خاطر بسپار
                </label>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">ورود</button>
            <p class="text-body-secondary mt-3">هنوز در سایت ثبت‌نام نکرده‌اید؟ <a href="{{ route('register') }}">عضویت</a></p>
            <p class="mt-5 mb-3 text-body-secondary">© ۱۴۰۳ |           <span class="text-body-secondary text-center">تمام حقوق این وبسایت برای شرکت توسعه تجارت الکترونیک رسا محفوظ است.</span>
            </p>
    </form>
</main>
@endsection
