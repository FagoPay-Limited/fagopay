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
                                            <form class="contact-form" class="currency_validate" action="" method="post" enctype="multipart/form-data">
                                        @csrf

                                                <div class="row">
                                                <div class="form-group col-12" >
                                                    <label class="@if(Auth::user()->darkmode != 0) text-white @endif">Select Preferred Company</label>
                                                    <div class="input-group mb-3">

                                                        <select name="company" class="form-control" data-placeholder="Network">
													<option selected disabled label="Choose one">Select Company
													</option>
													@foreach($network as $data)
													<option value="{{$data->billercode}}">{{$data->name}}</option>
													@endforeach
												</select>
                                                    </div>
                                                </div>




                                                <div class="form-group col-12">
                                                    <label class="@if(Auth::user()->darkmode != 0) text-white @endif">Select Meter Type</label>
                                                    <div class="input-group mb-3">
                                                         <select id="s2" name="type" class="form-control ">
<option selected disabled>Select Meter Type</option>

<option value="prepaid">Prepaid</option>
<option value="postpaid">Postpaid</option>

</select>

                                                    </div>

                                                </div>



                                                <div class="form-group col-12">
                                                    <label class="@if(Auth::user()->darkmode != 0) text-white @endif">Enter Meter Number</label>
                                                    <div class="input-group mb-3">
                                                         <input class="form-control" name="number" type="number" placeholder="123456789">

                                                    </div>

                                                </div>

                                                <div class="form-group col-12">
                                                    <label class="@if(Auth::user()->darkmode != 0) text-white @endif">Enter An amount</label>
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" name="amount"  id="usd" onkeyup="myFunction()" type="number" placeholder="0.00">

                                                    </div>

                                                    <button type="submit" class="btn btn-primary text-white">Buy Power</button>


                                                </div>


                                        </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                </div> 

                <!-- row opened -->
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Recent Utility Bills Payment Log </div>
										<div class="card-options">
											<a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
											<a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen"><i class="fe fe-maximize"></i></a>
											<a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
										</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table card-table table-striped text-nowrap table-bordered border-top">
												<thead>
													<tr>
														<th>ID</th>
														<th>Customer</th>
														<th>Company</th>
														<th>Amount</th>
														<th>Details</th>
														<th>Status</th>
														<th>Date</th>
													</tr>
												</thead>
												<tbody>
												@foreach($bills as $data)
													<tr>
														<td>#{{$data->trx}}</td>
														<td class="text-success">
														{!!$data->accountname!!}
														</td>
														<td>{{strtoupper($data->network)}}<br>
														</td>

														<td>₦‎{{number_format($data->amount,2)}}</td>


														<td class="text-success"><a href="{{route('user.utilitytoken',$data->trx)}}" class="btn btn--primary btn-sm">Print Token</a></td>

                                                       @if($data->status == 0)
														<td><span class="badge bg-warning badge-pill">Pending</span></td>
														@elseif($data->status == 1)
														<td><span class="badge bg-success badge-pill">Completed</span></td>
														@else
														<td><span class="badge bg-danger badge-pill">Declined</span></td>
														@endif
														<td>{{date(' d M, Y ', strtotime($data->created_at))}} {{date('h:i A', strtotime($data->created_at))}}</td>
													</tr>
											  @endforeach


												</tbody>
											</table>
											 @if(count($bills) < 1)
											 <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
			<span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
			<span class="alert-inner--text"><strong>Hey Boss!</strong>   You dont have any transaction log at the moment</span>

		</div>

											  @endif
										</div>
									</div>
								</div>
							</div>



                </div>
            </div> 

 

@endsection
