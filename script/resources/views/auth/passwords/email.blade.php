@extends('layouts.auth.app')

@section('title', __('Reset Password'))

@section('form')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
   
                    <div class="login-content">
                     
    <form method="POST" action="{{ route('password.email') }}" class="ajaxform_instant_reload">
        @csrf

        <div class="input_field">
            
            <input type="text" class="form-control focus-input100" name="email" placeholder="Email Address" required>
            
        </div><br><br>
<button type="submit" class="site-btn w-100 submit-btn">{{ __('Send Password Reset Link') }}</button>
       
    </form>
@endsection
