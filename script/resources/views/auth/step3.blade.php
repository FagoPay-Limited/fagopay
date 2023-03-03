@extends('layouts.auth.app', [
    'columnClass' => 'col-lg-8'
])

@section('title', __('STEP 3'))

@section('form')
@push('style')
<style> 
.card {
    width: 400px;
    border: none;
    height: 300px;
    box-shadow: 0px 5px 20px 0px #d2dae3;
    z-index: 1;
    display: flex;
    justify-content: center;
    align-items: center
}

.card h6 {
    color: rgba(25, 2, 30, 0.899);
}

.inputs input {
    width: 40px;
    height: 40px
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0
}

.card-2 {
    background-color: #fff;
    padding: 10px;
    width: 350px;
    height: 100px;
    bottom: -50px;
    left: 20px;
    position: absolute;
    border-radius: 5px
}

.card-2 .content {
    margin-top: 50px
}

.card-2 .content a {
    color: red
}

.form-control:focus {
    box-shadow: none;
    border: 2px solid red
}

.validate {
    border-radius: 20px;
    height: 40px;
    background-color: red;
    border: 1px solid red;
    width: 140px
}

</style>
@endpush
<div class="container height-100 d-flex justify-content-center align-items-center">
  <form action="{{ route('auth.register.step3') }}"  method="post">
		@csrf
  <div class="position-relative">

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
        <strong>{{ $message }}</strong>
</div>
@endif
{{--{{session()->get('step3otp')}}--}}{{session()->get('step3otp')}}
      <div class="card p-2 text-center">
          <h6>Please enter the one time password sent to <b>{{session()->get('step2value')}}</b> to verify your account</h6>
          <div>  <small></small> </div>
          <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2"> 
            <input class="m-2 text-center form-control rounded" type="text"  name="f1"  id="first"  required maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text"  name="f2" id="second" required maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text"  name="f3" id="third"  required maxlength="1" /> 
            <input class="m-2 text-center form-control rounded" type="text"  name="f4" id="fourth" required  maxlength="1" />
             <input class="m-2 text-center form-control rounded" type="text" name="f5" id="fifth" required  maxlength="1" /> 
             <input class="m-2 text-center form-control rounded" type="text" name="f6"  id="sixth" required  maxlength="1" /> 
          </div>
          <div class="mt-4"> <button  class="site-btn w-100 submit-btn"  type="submit">Validate</button> </div>
      </div>
  </div>
  </form>
</div>
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
