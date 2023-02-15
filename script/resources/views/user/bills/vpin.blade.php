@extends('layouts.user.master')

@section('title', __('VPIN'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('VPIN') }}</li>
@endsection 
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
                                                    <label>Select Preferred Network</label>
                                                    <div class="input-group mb-3">

                                                        <select name="network" class="form-control" data-placeholder="Network">
													<option label="Choose one">Select Network
													</option>
													@foreach($network as $data)
													<option value="{{$data->code}}">{{$data->name}}</option>
													@endforeach
												</select>
                                                    </div>
                                                </div>



                                                <div class="form-group col-12">
                                                    <label>Enter Unit</label>
                                                    <div class="input-group mb-3">
													<select name="amount" class="form-control" data-placeholder="Amount">
														<option label="Choose one">Select Amount
														</option>
 														<option value="100">100</option>
 														<option value="200">200</option>
 														<option value="500">500</option>
 														<option value="1000">1000</option>
 														<option value="2000">2000</option>
													</select>

                                                    </div>

                                                </div>

                                                <div class="form-group col-12">
                                                    <label class="@if(Auth::user()->darkmode != 0) text-white @endif">Enter Unit</label>
                                                    <div class="input-group mb-3">
                                                        <input class="form-control" name="unit"  id="unit" onkeyup="myFunction()" type="number" placeholder="1">

                                                    </div>

                                                    <button type="submit" class="btn btn-primary text-white">Generate</button>


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
										<div class="card-title">Recent V-Pin Log </div>
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
														<th>Unit</th>
														<th>Network</th>
														<th>Amount</th>
														<th>Value</th>
														<th>Date</th>
														<th></th>
													</tr>
												</thead>
												<tbody>
												@foreach($logs as $data)
													<tr>
														<td class="text-primary">#{{$data->trx}}</td>
														<td >{{$data->unit}}</td>
														<td>{{strtoupper($data->network)}}<br>
														</td>

														<td>{{$general->cur_sym}}{{number_format($data->total,2)}}</td>
														<td>{{$general->cur_sym}}{{number_format($data->amount,2)}}</td>
 
														<td>{{date(' d M, Y ', strtotime($data->created_at))}} {{date('h:i A', strtotime($data->created_at))}}</td>
														<td><a href="{{ route('user.vpinview',$data->trx) }}" class="badge bg-warning badge-pill">View</a></td>
													
													</tr>
											  @endforeach


												</tbody>
											</table>
											 @if(count($logs) < 1)
											 <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
			<span class="alert-inner--icon"><i class="fe fe-slash"></i></span>
			<span class="alert-inner--text"><strong>Hey Boss!</strong>   You dont have any V-Pin log at the moment</span>

		</div>

											  @endif
										</div>
									</div>
								</div>
							</div>



                </div>



				</div>
 

 
@endsection 