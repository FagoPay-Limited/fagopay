@extends('layouts.auth.app')

@section('title', __('Verify your email ✉️'))

@section('form')
    <p class="mb-2">
        {!! __("We've sent a link to your email address: :email. Please follow the link inside to continue.", ['email' => '<span class="fw-bolder">'.auth()->user()->email.'</span>']) !!}
    </p>

    @if (session('resent'))
        <div class="alert alert-success" role="alert">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <form class="ajaxform_instant_reload text-center d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf

        <p class="text-center mt-2">
            <span>{{ __("Didn't receive an email?") }}</span><br>
            <button type="submit" class="site-btn submit-btn">{{ __('Resend') }}</button>
        </p>
    </form>

@endsection
