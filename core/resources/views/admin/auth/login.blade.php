@extends('admin.layouts.master')
@section('content')
<div class="login-main"
    style="background-image: url('{{ asset('assets/admin/images/login.jpg') }}');">
    <div class="container custom-container">
        <div class="row justify-content-center">
            <div class="col-xxl-5 col-xl-5 col-lg-6 col-md-8 col-sm-11">
                <div class="login-area">
                    <div class="login-wrapper">
                        <div class="login-wrapper__top">
                            <h3 class="title text-white">@lang('Welcome to') <strong style="color: #3A815C;">{{ __(gs('site_name')) }}</strong></h3>
                            <p class="text-white">{{ __($pageTitle) }} @lang('to') <span style="color: #3A815C;">{{ __(gs('site_name')) }}</span>
                                @lang('Dashboard')</p>
                        </div>
                        <div class="login-wrapper__body">
                            @if ($errors->any())
                                <div class="alert alert-danger my-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                    <p>Debug information:</p>
                                    <pre>{{ json_encode($errors->toArray(), JSON_PRETTY_PRINT) }}</pre>
                                </div>
                            @endif
                            <form action="{{ route('admin.login') }}" method="POST"
                                class="cmn-form mt-30 verify-gcaptcha login-form">
                                @csrf
                                <div class="form-group">
                                    <label>@lang('Username')</label>
                                    <input type="text" class="form-control" value="{{ old('username') }}" name="username" required>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label>@lang('Password')</label>
                                        <a href="{{ route('admin.password.reset') }}" class="forget-text" style="color: #3A815C;">@lang('Forgot Password?')</a>
                                    </div>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <x-captcha />
                                <button type="submit" class="btn cmn-btn w-100" style="background-color: #3A815C; border-color: #3A815C;">@lang('LOGIN')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
