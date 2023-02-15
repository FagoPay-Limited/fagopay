@extends('layouts.frontend.masterr')

@section('body')

    @include('layouts.frontend.partials.header')

    @yield('content')

    @include('layouts.frontend.partials.footer')
    
   
@endsection
