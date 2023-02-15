<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
   
    


    <!-- Favicon -->
    <link rel="icon" href="{{ get_option('logo_setting', true)->favicon ?? null }}"/>
       <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
       
    <!-- Import css File -->
    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/headstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/mobilehead.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/show.css') }}">
    

    <link rel="stylesheet" href="{{ asset('plugins/toastify-js/src/toastify.css') }}">

<script type="text/javascript">
$(document).ready(function(){
    $("#closee").click(function(){
       $(".menuu").removeClass("kuda-mobile--menu");
    });
    
    
});
</script>

<script type="text/javascript">
$(document).ready(function(){
 $("#openn").click(function(){
       $(".menuu2").addClass("kuda-mobile--menu");
    });
});
</script> 

  
    @yield('css')
    @stack('css')

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/custom.css') }}">

</head>

<body @class([$bodyClass ?? null])>

@yield('body')


</body>

</html>
