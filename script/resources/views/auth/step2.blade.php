@extends('layouts.auth.app', [
    'columnClass' => 'col-lg-8'
])

@section('title', __('STEP 2'))

@section('form')
@push('style')
<style>
   @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=cyrillic,latin);

/* -------------------------------- 

Primary style

-------------------------------- */
*, *::after, *::before {
  box-sizing: border-box;
  outline: 0;
  padding: 0;
  argin: 0;
}

*::after, *::before {
  content: '';
}

body {
  font-size: 100%;
  font-family: 'Open Sans', sans-serif;
  font-weight: normal;
  color: #444;
  background-color: #fafafa;
}

a {
  color: #444;
  text-decoration: none;
}

/* -------------------------------- 

Main components 

-------------------------------- */

.logo {
  display: block;
  margin: 0 auto;
  margin-top: 5%;
  margin-bottom: 20px;
  width: 120px;
  height: 120px;
  opacity: 0.5;
}

.cd-tabs {
  position: relative;
  width: 90%;
  max-width: 600px;
  min-width: 400px;
  margin: 0 auto;
}
.cd-tabs:after {
  content: '';
  display: table;
  clear: both;
}

.cd-tabs nav {
  overflow: hidden;
  position: relative;
}
.cd-tabs-navigation:after {
  content: "";
  display: table;
  clear: both;
}

  .cd-tabs-navigation {
    padding: 0;
    margin: 0;
    width: 100%;
    background-color: #fff;
    border: 1px solid #e9e9e9;
    border-bottom: none;
    box-shadow: 0 2px 1px #f1f1f1;
    }

  .cd-tabs-navigation li {
    display: block;
    float: left;
    height: 60px;
    width: 49%;
    max-width: 298px;
    line-height: 60px;
    text-align: center;
   }
  .cd-tabs-navigation a {
    position: relative;
    display: block;
    height: 60px;
    width: 100%;
    font-size: 18px;
    padding: 0 0 0 20px;
  }
  .cd-tabs-navigation a::before {
  /* icons */
  position: absolute;
    top: 50%;
    margin-top: -16px;
    left: 30%;
  display: inline-block;
  height: 26px;
  width: 26px;
  background: url('http://image005.flaticon.com/1/svg/32/32317.svg');
  background-repeat: no-repeat;
  background-size: contain;
}

.cd-tabs-navigation a[data-content='signup']::before {
  background-image: url('http://image005.flaticon.com/1/svg/1/1819.svg');
}

  .cd-tabs-navigation a.selected {
    box-shadow: inset 0 2px 0 #f05451;
  }

  .cd-tabs-navigation a[data-content='signup']::before {
    left: 20%;
  }

/* трохи попраимо розміщення іконок коли вікно стає меншим */
@media only screen and (max-width: 768px) {
  .cd-tabs-navigation a::before {
    left: 20%;
  }

  .cd-tabs-navigation a[data-content='signup']::before {
    left: 8%;
  }
}

.cd-tabs-navigation a.selected {
  background-color: #fff !important;
  box-shadow: inset 0 2px #f05451;
  color: #29314e;
}

/* -------------------------------- 

Вміст вкладок 

-------------------------------- */

.cd-tabs-content {
  background: #ffffff;
  margin: 0;
  pading: 0;
}
.cd-tabs-content li {
  display: none;
  padding: 1.4em;
}
.cd-tabs-content li.selected {
  border: 1px solid #e9e9e9;
  border-top: 1px solid rgba(0,0,0,.02);
  box-shadow: 0 2px 1px #f1f1f1;
  display: block;

  -webkit-animation: cd-fade-in 0.5s;
  animation: cd-fade-in 0.5s;
}

form {
  display: block;
  position: relative;
}

.form-fild {
  position: relative;
  display: block;
  width: 90%;
  height: 60px;
  margin: 10px auto;
}

.form-fild input {
  position: relative;
  z-index: 99;
  border: none;
  border-bottom: 1px solid #e0e0e0; 
  display: block;
  width: 100%;
  height: 40px;
  outline: none;
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
  color: #444;
  background: transparent;
} 

input:-webkit-autofil,
textarea:-webkit-autofill, 
select:-webkit-autofill  {background-color: transparent;}

.form-fild label {
  position: absolute;
  top: 7px;
  text-transform: lowercase;
  transition: all 0.3s;
}

label.focused {
  font-size: 12px;
  top: -10px;
}

form button {
  display: block;
  width: 100px;
  height: 40px;
  margin: 0 auto;
  margin-top: 10px;
  background: none;
  border: 1px solid #B3B3B3;
  text-transform: uppercase;
  color: #444;
  cursor: pointer;
  transition: all 0.3s;
}

form button:hover {
  border: 1px solid #444;
}

/* тут буде вставляти текст помилок */
.error {
    display: none;
    position: absolute;
    width: 184px;
    line-height: 18px;
    top: -198px;
    left: 353px;
    padding: 10px;
    color: #DC3B3B;
    background: rgba(255, 0, 0, 0.17);
    text-transform: uppercase;
    font-size: 15px;
    text-align: center;
}

@-webkit-keyframes cd-fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}
@keyframes cd-fade-in {
  0% {
    opacity: 0;
  }
  100% {
    opacity: 1;
  }
}

/* -------------------------------- 

FOOTER

-------------------------------- */

footer {
  margin-top: 100px;
  display: block;
  heigth: 60px;
  width: 100%;
  text-align: center;
/*   background: #000; */
  border-top: 1px solid #f05451; 
  line-height: 60px;
}

footer a {border-bottom: 3px solid rgba(0,0,0,.1);}
footer a:hover {border-bottom: 3px solid rgba(0,0,0,.6);}
</style>
@endpush
<div class="cd-tabs">
	<h5 class="text-secondary">Please select either phone number or email to continue</h5>
	<br>
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <strong>{{ $message }}</strong>
</div>
@endif
  <nav>
	<ul class="cd-tabs-navigation">
	  <li><a href="#" data-content="login" class="selected">Phone Number</a></li>
	  <li><a href="#" data-content="signup">Email</a></li>
	</ul>
  </nav>
  <ul class="cd-tabs-content">
	<li data-content="login" class="selected">

		<form action="{{ route('auth.register.step2') }}" method="post">
			@csrf		
		<div class="form-fild">
		  <input name="type" value="phone" hidden>
		  <input type="text" required  name="value" placeholder="08023456789">
		</div>
		<center><span class="text-secondary">A verification code will be sent to this phone number, please ensure you enter a valid phone number</span></center>
		<button  class="site-btn w-100 submit-btn"  type="submit">Proceed</button>
	  </form>
	</li>
	<li data-content="signup">
		<form action="{{ route('auth.register.step2') }}" method="post">
		@csrf
		<div class="form-fild">
		  <input name="type" value="email" hidden>
		  <input type="email" required name="value" placeholder="example@mail.com">
		</div>
		<center><span class="text-secondary">A verification code will be sent to this email address, please ensure you enter a valid email address</span></center>
		<button  class="site-btn w-100 submit-btn" type="submit">Proceed</button>
	  </form>
	</li>
  </ul>
</div> <!-- end cd-tabs -->

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

	'use strict';

window.addEventListener('load', windowLoaded, false);

function windowLoaded() {
	var 
		tabs = document.querySelectorAll('.cd-tabs')[0],
		login = document.querySelectorAll('a[data-content=\'login\']')[0],
		signup = document.querySelectorAll('a[data-content=\'signup\']')[0],
		tabContentWrapper = document.querySelectorAll('ul.cd-tabs-content')[0],
		currentContent = document.querySelectorAll('li.selected')[0];

	login.addEventListener('click', clicked, false);
	signup.addEventListener('click', clicked, false);

	function clicked(event) {
		event.preventDefault();
    
		var selectedItem = event.currentTarget;
		if (selectedItem.className === 'selected') {
      // ...       
		} else {
			var selectedTab = selectedItem.getAttribute('data-content'),
				selectedContent = document.querySelectorAll('li[data-content=\'' + selectedTab + '\']')[0];

			if (selectedItem == login) {
				signup.className = '';
				login.className = 'selected';
			} else {
				login.className = '';
				signup.className = 'selected';
			}

			currentContent.className = '';
			currentContent = selectedContent;
			selectedContent.className = 'selected';

		}
	}

	var inputs = document.querySelectorAll('input');
	for (var i = 0; i < inputs.length; i++) {
		inputs[i].addEventListener('focus', inputFocused, false);
	}

	function inputFocused(event) {
		var label = document.querySelectorAll('label[for=\''+ this.name +'\']')[0];
		label.className = 'focused';
	}
}	

    </script>
@endsection
