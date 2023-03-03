@extends('layouts.auth.app', [
    'columnClass' => 'col-lg-8'
])

@section('title', __('STEP 4'))

@section('form')
@push('style')
<style> 
</style>
@endpush
 
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
        <strong>{{ $message }}</strong>
</div>

@endif
<form action="{{ route('auth.register.step4') }}"  method="post">
    @csrf
   
    <div class="mb-5f per" >
        <label for="name" class="col-form-label">{{ __('First Name') }}</label>
        <input type="text" class="form-control focus-input100" name="firstname" id="name" placeholder="{{ __('Your first name') }}" required >
    </div>

    <div class="mb-5f per" >
        <label for="name" class="col-form-label">{{ __('Last Name') }}</label>
        <input type="text" class="form-control focus-input100" name="lastname" id="name" placeholder="{{ __('Your last name') }}" required>
    </div>


    <div class="row">
        @if(session()->get('step2type') == 'email')
        <div class="col-md-12 mb-5f">
            <label for="phone" class="col-form-label">Phone</label>
            <input type="text" class="form-control focus-input100" name="phone" id="phone" placeholder="{{ __('Your Phone Number') }}" required>
        </div>
        @endif
        @if(session()->get('step2type') == 'phone')
        <div class="col-md-12 mb-5f">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" class="form-control focus-input100" name="email" id="email" placeholder="{{ __('Your email address') }}" required>
        </div>
        @endif
        @if(session()->get('step1') == 2)
        <div class="col-md-12 mb-5f">
            <label for="business" class="col-form-label">Business Name</label>
            <input type="text" class="form-control focus-input100" name="business" id="business" placeholder="{{ __('Your Business Name') }}" required>
        </div>
        @endif
         
    </div>
    <br>

      

    <!-- Button -->
    <button type="submit" class="site-btn w-100 submit-btn">{{ __('Continue') }}</button>
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
document.addEventListener("DOMContentLoaded", function(event) {
function OTPInput() {
const inputs = document.querySelectorAll('#otp > *[id]');
for (let i = 0; i < inputs.length; i++) { inputs[i].addEventListener('keydown', function(event) { if (event.key==="Backspace" ) { inputs[i].value='' ; if (i !==0) inputs[i - 1].focus(); } else { if (i===inputs.length - 1 && inputs[i].value !=='' ) { return true; } else if (event.keyCode> 47 && event.keyCode < 58) { inputs[i].value=event.key; if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } else if (event.keyCode> 64 && event.keyCode < 91) { inputs[i].value=String.fromCharCode(event.keyCode); if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } } }); } } OTPInput(); });
 </script>
@endsection
