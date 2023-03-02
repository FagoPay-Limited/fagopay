@extends('layouts.auth.app', [
    'columnClass' => 'col-lg-8'
])

@section('title', __('Register'))

@section('form')
@push('style')
<style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@100;400;500;900&display=swap");

:root {
	--primary: #191919;
	--secondary: #f26db6;
	--ternary: #310273;
	--background: #f1f1f1;
	--gray: #e1eeff7f;
	--white: #fff;
}

body {
	color: var(--font-color);
	font-family: "Inter", sans-serif;
	font-size: 1.2em;
	line-height: 1.6;
	background: var(--background);
	overflow-x: hidden;
	min-height: 100vh;
	min-width: 100vw;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.caption {
	font-size: 10px;
	font-style: normal;
	font-weight: 700;
	line-height: 13px;
	letter-spacing: 0.04em;
	text-align: left;
	text-transform: uppercase;
	color: var(--secondary);
}
.title {
	font-size: 24px;
	font-style: normal;
	font-weight: bold;
	line-height: 31px;
	letter-spacing: 0em;
	text-align: center;
	margin-bottom: 8px;
	color: var(--secondary);
}

.faq {
	max-width: 800px;
	margin: auto;
}
.box-content-colapse {
	width: 70%;
	height: auto;
	position: relative;
}

.intro-colapse {
	width: 100%;
	height: auto;
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.details-comp {
	cursor: pointer;
	width: calc(100% - 32px);
	padding: 16px;
	border-radius: 8px;
	margin-bottom: 32px;
	position: relative;
	left: 0px;
	background: white;
	filter: drop-shadow(7px 9px 5px rgba(0, 0, 0, 0.04));
	-webkit-filter: drop-shadow(7px 9px 5px rgba(0, 0, 0, 0.04));
	-moz-filter: drop-shadow(7px 9px 5px rgba(0, 0, 0, 0.04));
}

.details-comp > p {
	padding: 0 16px;
}

.summary-colapse {
	list-style: none;
	border-radius: 8px;
	padding-left: 16px;
	color: var(--ternary);
	font-weight: bold;
	display: flex;
	flex-direction: row;
	justify-content: space-between;
	align-items: center;
	width: 100%;
}
.summary-colapse::-webkit-details-marker {
	display: none;
}

.details-comp[open] > .summary-colapse::after {
	display: flex;
	justify-content: space-between;
	content: url("https://cdn-icons-png.flaticon.com/24/7153/7153564.png");
	font-size: 16px;
	align-items: center;
	padding-right: 24px;
}

.details-comp > .summary-colapse::after {
	display: flex;
	justify-content: space-between;
	align-items: center;
	content: url("https://cdn-icons-png.flaticon.com/24/7153/7153566.png");
	font-size: 16px;
	padding-right: 24px;
}

.details-comp[open] p {
	animation: details-show 350ms linear;
}

.details-comp:not([open]) p {
	opacity: 0;
}

@keyframes details-show {
	0% {
		opacity: 0;
		transform: translatey(-25px);
	}
	100% {
		opacity: 1;
		transform: translatey(0);
	}
}

</style>
@endpush
{{--

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
--}}

<details class="details-comp">

    @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block">
            <strong>{{ $message }}</strong>
    </div>
    @endif
    @if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
    </div>
    @endif
    <summary class="summary-colapse">
        Personal Account
    </summary>
    <p> Are you a professional, creatore or you live abroad? You can collect payment</p><br>
    <form action="{{ route('auth.register.step1') }}" method="post">
    @csrf
    <input value="1" name="type" hidden>
    <button type="submit" class="site-btn w-100 submit-btn">Click Here</button>
    </form>
</details>

<details class="details-comp">
    <summary class="summary-colapse">
       Business Account
    </summary>
    <p> Are you a professional, creatore or you live abroad? You can collect payment</p><br>
    <form action="{{ route('auth.register.step1') }}" method="post">
        @csrf
        <input value="2" name="type" hidden>
        <button type="submit" class="site-btn w-100 submit-btn">Click Here</button>
    </form>
</details>

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
