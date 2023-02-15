@extends('layouts.user.master')

@section('title', __('Swap Airtime'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Swap Airtime') }}</li>
@endsection 
@section('content')

<div id="content" class="main-content">
<div class="layout-px-spacing">
	 <div class="card card-bordered">
    <div class="card-inner">
        <div class="team">

<div class="alert alert-icon alert-danger" role="alert">
    <em class="icon ni ni-alert-circle"></em> 
<center>	Kindly transfer the sum of<b> {{number_format($log->amount,2)}}<small>NGN</small></b> to the phone number below and click on the complete button once process has been completed
    <br><b>Please do not call this number</b>
</center>
</div>
<hr>

<div class="alert alert-icon alert-primary" role="alert">
    <em class="icon ni ni-alert-circle"></em> 
	{!! $network->conversion_note !!}
</div>

            
            <div class="user-card user-card-s2">
			<div class="pricing-media">
				<img src="{{asset('assets/images/bills')}}/{{strTolower($network->name)}}.jpg" width="50"  alt="">
			</div>
                <div class="user-info">
                    <h6>{{$network->name}}</h6>
                </div>
            </div>

			
            <ul class="team-info">
                <li><b class="text-info">Phone Number</b><b class="text-info">{{$log->beneficiary}}</b></li>
                <li><b class="text-primary">Transaction Number</b><b class="text-primary">{{$log->trx}}</b></li>
                <li><b>Airtime Amount</b><b>₦‎ {{number_format($log->amount,2)}}</b></li>
                <li><b class="text-success">Airtime Value</b><b class="text-success">₦‎ {{number_format($log->receive,2)}}</b></li>
            </ul>
			<small class="text-danger">Transaction charge for this conversion is <b>₦‎{{number_format($log->charge,2)}}</b></small>
            <div class="team-view">
                <a href="#" data-bs-toggle="modal" data-bs-target="#modalDefault" class="btn btn-block btn-dim btn-primary"><span>Complete</span></a>
            </div>
        </div><!-- .team -->
    </div><!-- .card-inner -->
</div><!-- .card -->
 
</div>
</div>
 

<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="modalDefault">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">Are You Sure?</h5>
            </div>
            <div class="modal-body">
                <p>Click on the OK button below if you have successfully sent <b>₦‎ {{number_format($log->amount,2)}}</b> worth of <b>{{$network->name}}</b> airtime to <b>{{$log->beneficiary}}</b></p>
            </div>
            <div class="modal-footer bg-light">
			<form class="contact-form" class="currency_validate" action="" method="post">
            @csrf
			<button type="sunmit" class="btn btn-block btn-dim btn-success"><span>OK</span></button>
			</form>
			</div>
        </div>
    </div>
</div>

@endsection 