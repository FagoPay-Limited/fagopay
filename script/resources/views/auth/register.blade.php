@extends('layouts.auth.app', [
    'columnClass' => 'col-lg-8'
])

@section('title', __('Register'))

@section('form')


    <form action="{{ route('register') }}" method="post" class="ajaxform_instant_reload">
        @csrf
        
         <div class="mb-5f">
            <label for="country" class="col-form-label">{{ __('Type') }}</label>
            <select class="form-control focus-input100 type" name="type" id="type" required>
                <option value="1">Personal Account</option>
                <option value="2">Business Account</option>
            </select>
        </div>
        
        <div class="mb-5f per" >
            <label for="name" class="col-form-label">{{ __('Full Name') }}</label>
            <input type="text" class="form-control focus-input100" name="namee" id="name" placeholder="{{ __('Your full name') }}" >
        </div>
        
        
        <div class="row">
            <div class="col-md-6 mb-5f bus">
                <label for="business_name" class="col-form-label">{{ __('Business Name') }}</label>
                <input type="text" class="form-control focus-input100" name="business_name" id="business_name" placeholder="{{ __('Enter your business name') }}" >
            </div>
            <div class="col-md-6 mb-5f bus">
                <label for="name" class="col-form-label">{{ __('Full Name') }}</label>
                <input type="text" class="form-control focus-input100" name="name" id="name" placeholder="{{ __('Your full name') }}" >
            </div>
            <div class="col-md-6 mb-5f">
                <label for="email" class="col-form-label">{{ __('Email') }}</label>
                <input type="email" class="form-control focus-input100" name="email" id="email" placeholder="{{ __('Your email address') }}" required>
            </div>
            <div class="col-md-6 mb-5f">
                 <label for="password" class="col-form-label">{{ __('Password') }}</label>
                 <input type="password" class="form-control focus-input100" name="password" id="password" placeholder="{{ __('Type Password') }}" min="6" required autocomplete="new-password">
            </div>
        </div>

        <div class="mb-20">
            <label for="country" class="col-form-label">{{ __('Country') }}</label>
            <select class="form-control focus-input100" name="country" id="country" required>
                @foreach($currencies as $id => $country)
                    <option value="{{ $id }}">{{ $country }}</option>
                @endforeach
            </select>
        </div>

       

        <div class="form-check form-check-inline mb-20">
            <input class="form-check-input" type="checkbox" name="agree" id="agree">
            <label class="form-check-label" for="agree">{!! __('agree_term_of_service_checkbox', ['url' => url('/terms')]) !!}</label>
        </div>

        <!-- Button -->
        <button type="submit" class="site-btn w-100 submit-btn">{{ __('Create Account') }}</button>
    </form>

    <!-- Other Sign Up -->
    <div class="other-sign-up-area text-center">
        <p>{{ __('Or Sign Up Using') }}</p>
        <span>{{ __('Already have an account?') }} <a href="{{ route('login') }}">{{ __('Login') }}</a></span>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(function() {
         $('.bus').hide(); 
    $('#type').change(function(){
        if($('#type').val() == '2') {
            $('.bus').show(); 
            $('.per').hide(); 
        } else {
            $('.per').show(); 
            $('.bus').hide(); 
        } 
    });
    });
    

    </script>
@endsection
