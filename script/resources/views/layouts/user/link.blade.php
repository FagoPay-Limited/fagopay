<!doctype html>
<html class="no-js" lang="en">
    <head>
        <base href="{{url('/')}}"/>
        <title>@hasSection('title')@yield('title') | @endif {{ config('app.name') }}</title>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <meta name="robots" content="index, follow">
        <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}"/>
        <meta name="application-name" content="{{ config('app.name') }}"/>
        <meta name="msapplication-TileColor" content="#ffffff"/>
        <meta name="description" content="{{ config('app.name') }}" />
        <link rel="shortcut icon" href="{{ asset(get_option('logo_setting', true)->favicon ?? null) }}" />
        <link rel="stylesheet" href="{{url('/')}}/asset/css/toast.css" type="text/css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/vendor/datatables.net-select-bs4/css/select.bootstrap4.min.css">
        <link rel="stylesheet" href="{{url('/')}}/asset/dashboard/css/argon.css?v=1.1.0" type="text/css">
        <link href="{{url('/')}}/asset/fonts/fontawesome/css/all.css" rel="stylesheet" type="text/css">
        <link href="{{url('/')}}/asset/fonts/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
        

    </head>
<!-- header begin-->
<style>
        .hero-style-two {
    background: url({{url('/')}}/asset/home/png/hero-bg-2.png);
    background-size: contain;
    background-repeat: no-repeat;
    border-radius: 0% 0% 60% 20%;
}
</style>
<style>
.btn-inv {
    color: #fff;
    border-color: #480007;
    background-color: #ffffff33;
    box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
}

     .pwr {   
    background: url({{url('/')}}/asset/home/png/logc-02.png) ;
    background-size: contain;
    background-repeat: no-repeat;
}


.Text-color--gray500,.Text-color--gray600,.Text-color--gray700 {
    color: rgb(255 255 255 / 60%) !important;
}
.Text-color--gray800 {
    color: rgb(255 255 255 / 60%) !important;
}


  :root {
  --blue: #635BFF;
  --white: #ffffff;
  --text-default: #3c4257;
  --text-gray: #697386;
  --text-dark: #1a1f36;
  --icon-blue: #6c8eef;
  --icon-gray: #8792a2;

  --outline-color: rgba(58, 151, 212, 0.36);
  --outline-transition: box-shadow 0.2s ease;

  --standard-border-radius: 4px;

  --border: 1px solid rgba(60, 66, 87, 0.12);

  --shadow-small: 0px 2px 5px rgba(60, 66, 87, 0.12),
    0px 1px 1px rgba(0, 0, 0, 0.08);

  --shadow-button: 0px 2px 5px rgba(60, 66, 87, 0.12),
    0px 1px 1px rgba(0, 0, 0, 0.08), inset 0px -1px 1px rgba(0, 0, 0, 0.12);
  
  --button-background-color: #F2EBFF;
}

* {
  transition: outline 0.2s ease;
  outline-color: var(--outline-color);
}

body {
  min-height: 100vh;
  min-width: 320px;
  background-color: var(--white);
  background-color: #f6f8fb;
}

button {
  transition: var(--outline-transition);
  font-family: inherit;
}

button:focus {
  box-shadow: 0px 0px 0px 3px var(--outline-color);
  outline: none;
}

main {
  max-width: 1280px;
  margin: 0 auto;
  display: flex;
  flex-direction: column;
}

header {
  max-width: 1280px;
  padding: 28px 16px 0;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
}

.Column {
  flex: 1;
}

h2 {
  font-weight: 600;
  font-size: 20px;
  line-height: 28px;
  color: #1a1a1a;
}

.SuccessScreen {
  padding: 32px;
}



.bb2 {
    border-radius: 0px 30px 0px 0px;
    background: #f9f9f9;
}

@media only screen and (max-width:991px)  {
  .bb {
    padding: 0px ;
        
    }
.bbb {
    padding: 24px;
}
    .App-Footer {
    width: 50%;
}


  }
  
  
@media only screen and (max-width: 768px) {
  body {
    background-color: #f6f8fb;
    
    
  }

        .App-Footer {
    width: 100% ;
}
  }
  
  .App-Container {
    /* min-height: 0; */
    padding-left: 100px;
    padding-right: 100px;
    /* height: 100%; */
}
    .App-Container .App {
    box-shadow: 15px 0 30px 0 rgb(0 0 0 / 18%);
    border-radius: 30px;
        
    }
    
    
       .bb {
    padding: 50px ;
        
    }
  main {
    padding: 16px;
    flex-direction: row;
    justify-content: space-between;
  }

  header {
    padding: 44px 100px 0;
  }
}
.StepThree {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 40px;
  width: 100%;
}

.StepThree-Top {
  display: flex;
}

.StepThree-TestEntriesContainer {
  display: flex;
  align-items: flex-end;
  margin-bottom: 16px;
}

.StepThree-Actions {
  display: flex;
}

.StepThree-Actions > div {
  margin-top: 32px;
  margin-bottom: 16px;
}

.StepThree-Actions > div:not(:last-child) {
  margin-right: 12px;
}

.StepThree-TestInputs > .TestInputs:nth-last-child(n + 2) {
  margin-right: 300px;
}
.bbb {
    padding: 50px;
    }
    
   @media only screen and (max-width: 991px) { 
      .Text-color--gray800 {
    color: rgba(26,26,26,.9) !important;
}
}


@media only screen and (max-width: 768px) {
    
     .pwr {
    background: url({{url('/')}}/asset/home/png/hero-bg-2.png);
}


  .StepThree-TestInputs > .TestInputs:nth-last-child(n + 2) {
    bottom: -320px;
  }
  

  
      .App-Container .App {
    box-shadow: 15px 0 30px 0 rgb(0 0 0 / 18%);
    padding: 0px;
    border-radius: 30px;
    }
    
      .bb {
    padding: 70px;
    padding-bottom: 0px;
    }
    
    .bbb {
    padding: 10px;
    }
    
    .App-Container {
    /* min-height: 0; */
    padding-left: 0px;
    padding-right: 0px;
    /* height: 100%; */
}

.FakeChrome--desktop {
  width: calc(100% - 32px);
  /* Makes the iframe section calculate out to 760px tall */
  height: 100% !important;
}

.App-Container .App {
    width: 400px;
}
.App-Payment {
    padding: 40px !important;
}


}

@keyframes moveDown{
  0% {
    bottom: 0px
  }
  100% {
    bottom: -400px
  }
}

.StepThree-TestInputs--moveDown {
  animation: moveDown 0.3s;
  animation-fill-mode: forwards
}
.FakeChrome {
  background: #ffffff;
  box-shadow: 0px 20px 44px rgba(50, 50, 93, 0.12),
    0px -1px 32px rgba(50, 50, 93, 0.06), 0px 3px 12px rgba(0, 0, 0, 0.08);
  height: 496px;
  border-radius: 8px;
  min-width: 300px;
  transition: width 300ms, height 300ms;
}



.FakeChrome.FakeChrome-AnimateStep3--exited {
  width: 720px;
  height: 505px;
}

.FakeChrome.FakeChrome-AnimateStep2--exited {
  width: calc(100% - 32px) !important;
  height: 789px !important;
}

.FakeChrome-AnimateStep3--entered {
  transition: none;
}

@media (min-width: 768px) {
  .FakeChrome--desktop {
    min-width: 640px;
  }
}

.FakeChrome--mobile {
  width: 336px;
  border-radius: 48px;
  box-shadow: 0px 20px 44px rgba(50, 50, 93, 0.12),
    0px -1px 32px rgba(50, 50, 93, 0.06), 0px 3px 12px rgba(0, 0, 0, 0.08),
    inset 0px -2px 5px rgba(10, 37, 64, 0.35);
  padding: 8px;
  margin: 0 auto;
  height: 760px;
}

.FakeChrome-Wrapper {
  height: 100%;
  overflow-y: hidden;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
}

.FakeChrome-MobileWrapper {
  background: #ffffff;
  box-shadow: 0px 0px 2px rgba(10, 37, 64, 0.1);
  border-radius: 44px;
  overflow: hidden;
}

.FakeChrome-TopBar--mobile {
  background: rgb(247, 250, 252, 0.9);
  box-shadow: 0px 0.25px 0px #e3e8ee;
}

.FakeChrome-TopBar {
  background: #fcfeff;
  box-shadow: 0px 0.5px 0px #ecf2f7;
  padding: 6px 12px;
  border-radius: 8px 8px 0;
  display: flex;
  align-items: center;
}

.FakeChrome-TopBarButtons {
  display: flex;
  margin-right: 32px;
}

.FakeChrome-TopBarButtons > .FakeChrome-TopBarButton:not(:last-child) {
  margin-right: 6px;
}

.FakeChrome-TopBarButton {
  width: 8px;
  height: 8px;
  border-radius: 100%;
  background: #ecf2f7;
}

.FakeChrome-URLBar {
  display: flex;
  margin: 0 auto;
  align-items: center;
  justify-content: center;
  background: rgba(236, 242, 247, 0.4);
  border-radius: 12px;
  font-weight: 600;
  font-size: 8px;
  line-height: 12px;
  color: #0a2540;
  width: 615px;
  height: 20px;
}

.FakeChrome-URLBar--small {
  width: 410px;
}

.FakeChrome-URLBar--mobile {
  background: none;
}

.FakeChrome-URLBarIcon {
  margin-right: 4px;
}

.FakeChrome-CheckoutPreview {
  position: relative;
  height: 100%;
  margin-top: 1px;
  margin-bottom: -4px;
  overflow: hidden;
}

.FakeChrome--mobile .FakeChrome-CheckoutPreview {
  border-bottom-right-radius: 44px;
  border-bottom-left-radius: 44px;
}

.FakeChrome--desktop .FakeChrome-CheckoutPreview {
  border-bottom-right-radius: 8px;
  border-bottom-left-radius: 8px;
}

.FakeChrome-URLBarList {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  justify-items: center;
  padding: 0;
  margin: 0;
  list-style: none;
  align-items: center;
  width: 100%;
}


.FakeChrome-URLInputListItem {
  /* Used to properly center url */
  grid-column-start: 2; 
  display: flex;
  align-items: center;
}
.FakeChrome-URLInput {
  min-width: 5px;  
}
.FakeChrome-TopBarUrlChange {
  margin-left: auto;
}

.FakeChrome-TopBarUrlChangeButton {
  display: flex;
  align-items: center;
  padding: 0px 12px;
  gap: 4px;
  height: 20px;
  /* Gray/25 */
  background: rgba(26, 26, 26, 0.05);
  border-radius: 12px;
  user-select: none;
}

.FakeChrome--mobile .FakeChrome-TopBarUrlChange {
  padding-right: 20px;
}

.FakeChrome-TopBarUrlChangeButton:hover {
  background: var(--button-background-color);
  color: var(--blue);
}



.FakeChrome--auto {
  height: auto;
}

.FakeChrome--smallHeight {
  height: 525px;
}

.FakeChrome--URLTooltip {
  margin-left: 0;
}

.card-profile-imagee img {
    position: absolute;
    left: 50%;
    max-width: 80px;
    transition: all .15s ease;
    /* transform: translate(-50%, -50%) scale(1); */
    /* border: 3px solid #fff; */
    /* border-radius: 0.375rem; */
}

</style>

  <body class="hero-style-two">
   
<!-- header end -->

<link href="{{url('/')}}/asset/static/css/main.c59a1190.chunk.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/asset/static/css/checkout-app-init-1b9e3708c0baade976dfca50c4ba8172.css">


<div class="App"><main><div class="StepThree"><div class=" FakeChrome-AnimateStep3--entered FakeChrome--desktop"><div class="FakeChrome-Wrapper"><div class="FakeChrome-CheckoutPreview">


<div id="root">
    <div class="App-Container is-noBackground flex-container justify-content-center" data-testid="checkout-container">
        
          <div class=" justify-content-center">
            
              <div class="card-profile-imagee mb-5">
                  <img src="{{ avatar() }}" class="">
                  
                  
              </div>
              
             <h2 style="position: absolute;left: 50%;top: 8%;"><br>{{ $singleCharge->user->business_name}}</h2>
            </div>
            
          
        <div class="App App--multiItem row" style="background: linear-gradient(180deg, #420d36 5%, rgba(115,25,54,1) 100%);">
           
                
               @yield('body')
                
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{url('/')}}/asset/dashboard/vendor/jquery/dist/jquery.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/js-cookie/js.cookie.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
  <!-- Optional JS -->
  <script src="{{url('/')}}/asset/dashboard/vendor/chart.js/dist/Chart.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/chart.js/dist/Chart.extension.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/jvectormap-next/jquery-jvectormap.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/js/vendor/jvectormap/jquery-jvectormap-world-mill.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/datatables.net-select/js/dataTables.select.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/clipboard/dist/clipboard.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/select2/dist/js/select2.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/nouislider/distribute/nouislider.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/quill/dist/quill.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/dropzone/dist/min/dropzone.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
  <script src="{{url('/')}}/asset/dashboard/js/argon.js?v=1.1.0"></script>
  <script src="{{url('/')}}/asset/js/countries.js"></script>
  <script src="{{url('/')}}/asset/tinymce/tinymce.min.js"></script>
  <script src="{{url('/')}}/asset/tinymce/init-tinymce.js"></script>
  <script src="{{url('/')}}/asset/js/toast.js"></script>

  <script src="{{url('/')}}/asset/dashboard/js/card.js"></script>
</body>

</html>

<script type="text/javascript">
  "use strict";
  $('#xx').change(function() {
  $('#castro').val($('#xx').val());
  $('#xcastro').val($('#xx').val());
  });  
</script>
<script type="text/javascript">

    $(document).ready(function(){
 
    $('#wallet').click(function() {
      $('.wallet1').toggle("slide");
      $('.bank1').hide();
      $('.card1').hide();
    });
    
     $('#bank').click(function() {
      $('.bank1').toggle("slide");
      $('.wallet1').hide();
      $('.card1').hide();
    });
    
      $('#card').click(function() {
      $('.card1').toggle("slide");
      $('.wallet1').hide();
      $('.bank1').hide();
    });

    
});
</script>

