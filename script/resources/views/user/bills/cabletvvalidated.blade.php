@extends('layouts.user.master')

@section('content')


<div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="row layout-top-spacing">

                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
                    <div class="card">
            <div class="card-body">
 
   
                                <div class="buy-sell-widget">
                                     
                                    <div class="tab-content tab-content-default">
                                        <div class="tab-pane fade show active" id="buy" role="tabpanel">

													<div class="col-md-10">
														<div class="d-flex justify-content-between pb-10 pb-md-20 flex-column flex-md-row">
															<h1 class="display-4 font-weight-boldest mb-10">{{$decoder}}</h1>

														</div>
														<div class="border-bottom w-100"></div>
														<div class="d-flex justify-content-between pt-6">
															
															<div class="d-flex flex-column flex-root">
																<span class="font-weight-bolder mb-2">Decoder NO.</span>
																<span class="opacity-70">{{$number}}</span>
															</div>
															<div class="d-flex flex-column flex-root">
																<span class="font-weight-bolder mb-2">Customer.</span>
																<span class="opacity-70">{{$customer}}</span>
															</div>
 
															
														</div>
														<hr>
														<div class="d-flex flex-column flex-root">
																<span class="font-weight-bolder mb-2">Bouquet</span>
																<span class="opacity-70">{{$planname}}</span>
															</div>
														 
														 <br>
													</div>
													</div>
												</div>
												<!-- end: Invoice header--> 


												<div class="table-responsive">
															<table class="table">
																<thead>
																	<tr>
																		<th class="font-weight-bold text-muted text-uppercase">You Pay</th>
																		<th class="font-weight-bold text-muted text-uppercase">Charge</th>
																		<th class="font-weight-bold text-muted text-uppercase text-right">TOTAL AMOUNT</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="font-weight-bolder">
																		<td>₦‎{{$amount}}</td>
																		<td>₦‎{{env('CABLECHARGE')}}</td>
																		<td class="text-primary font-size-h3 font-weight-boldest text-right">₦‎{{number_format(env('CABLECHARGE') +$amount)}}</td>
																	</tr>
																</tbody>
															</table>
														</div>
														<br>
														<form class="form" id="kt_form"  method="post" enctype="multipart/form-data">
                                                                 @csrf
                                                            <input name="customer" hidden value="{{$customer}}">
                                                            <input name="number" hidden value="{{$number}}">
                                                            <input name="plan" hidden value="{{$plancode}}">
												
												
												
												<div class="text-center">
                            <button type="submit"  class=" submit btn btn-neutral submit-btn" >{{__('Make Payment')}} <!--<span id="resulttransfer"></span>--></button>
                        </div> 
                        
                      
															</form>

            </div>
          </div>
        </div>
      </div>
    </div>
        </div> 
    <!-- Product Details ends -->


@endsection


