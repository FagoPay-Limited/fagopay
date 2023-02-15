<!-- Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
<!-- Icons -->
<link rel="stylesheet" href="{{ asset('user/vendor/nucleo/css/nucleo.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('user/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
<!-- Argon CSS -->
<link rel="stylesheet" href="{{ asset('user/css/argon.css?v=1.1.0') }}" type="text/css">

<link rel="stylesheet" href="{{ asset('user/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/toastify-js/src/toastify.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquery-confirm-js/jquery-confirm.min.css') }}">
<link rel="stylesheet" href="{{ asset('user/custom.css') }}">
<style>
    .btn-neutral {
        color: #420D36;
        padding: 11px;
        margin: 3px;
        background-color: #e7dfdf;
        font-size: 13px;
        font-weight: 600;
    }
    .btn-neutral:hover {
        color: #fff;
        background-color: #420D36;
        border-color: transparent;
    }
</style>
@yield('css')
@stack('css')
