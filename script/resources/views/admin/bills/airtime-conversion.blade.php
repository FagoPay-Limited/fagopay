@extends('layouts.backend.app')

@section('content')
 <div class="row" id="basic-table">
  <div class="col-12">


                <div class="row">

                <!-- row opened -->
							<div class="col-xl-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">{{$pageTitle}} </div>
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
														<th>Network</th>
														<th>Sender</th>
														<th>Beneficiary</th>
														<th>Amount</th>
														<th>Charge</th>
														<th>Payable</th>
														<th>Status</th>
														<th>Date</th>
														@if($pageTitle == 'Pending Airtime Conversion')
														<th>Action</th>
														@endif
													</tr>
												</thead>
												<tbody>
												@foreach($bills as $data)
													<tr>
														<td>#{{$data->trx}}</td>
														<td class="text-success"><br>
														{{strtoupper($data->network)}}
														</td>

														<td>{{strtoupper($data->sender)}}<br>
														</td>

														<td>{{strtoupper($data->beneficiary)}}<br>
														</td>

														<td>₦‎{{number_format($data->amount,2)}}</td>
														<td>₦‎{{number_format($data->charge,2)}}
														</td>
														<td>₦‎{{number_format($data->receive,2)}}
														</td>
                                                       @if($data->status == 'pending')
														<td><span class="badge bg-warning badge-pill">Pending</span></td>
														@elseif($data->status == 'success')
														<td><span class="badge bg-success badge-pill">Completed</span></td>
														@elseif($data->status == 'declined')
														<td><span class="badge bg-danger badge-pill">Declined</span></td>
														@else
														<td><span class="badge bg-secondary badge-pill">Incomplete</span></td>
														@endif
														<td>{{date(' d M, Y ', strtotime($data->created_at))}} {{date('h:i A', strtotime($data->created_at))}}</td>
														@if($pageTitle == 'Pending Airtime Conversion')
														<td>
																													<a href="{{route('admin.bills.approve.conversion',$data->trx)}}" class="btn text-white btn-primary">@lang('Approve')</a>

																													<a href="{{route('admin.bills.decline.conversion',$data->trx)}}" class="btn text-white btn-primary">@lang('Proceed')</a>

														</td>
														@endif
													</tr>

											{{-- APPROVE MODAL --}}
											<div id="approveModal{{$data->id}}" class="modal fade" tabindex="-1" role="dialog">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">@lang('Approve Transaction')</h5>

														</div>
														<div class="modal-body">

															<div class="row">
																<div class="col-lg-12">
																You are about to approve this transaction. A total sum of ₦‎{{number_format($data->receive,2)}} will
																be credited into customer's wallet. Are you sure to proceed?
																</div>
															</div>
														</div>

															<div class="modal-footer">
																<button type="button" class="btn btn-warning" data-bs-dismiss="modal">@lang('Close')</button>
																<a href="{{route('admin.bills.approve.conversion',$data->trx)}}" class="btn text-white btn-primary">@lang('Approve')</a>
															</div>
													</div>
												</div>
											</div>


											{{-- REJECT MODAL --}}
											<div id="declineModal{{$data->id}}" class="modal fade" tabindex="-1" role="dialog">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title">@lang('Decline Transaction')</h5>

														</div>
														<div class="modal-body">

															<div class="row">
																<div class="col-lg-12">
																You are about to decline this conversion request. No fund will be credited to user for this action. Are you sure to proceed?
																</div>
															</div>
														</div>

															<div class="modal-footer">
																<button type="button" class="btn btn-warning" data-bs-dismiss="modal">@lang('Close')</button>
																<a href="{{route('admin.bills.decline.conversion',$data->trx)}}" class="btn text-white btn-primary">@lang('Proceed')</a>
															</div>
													</div>
												</div>
											</div>
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
									<div class="card-footer py-4">
										{{ $bills->links() }}
									</div>
								</div>
							</div>



                </div>
            </div>
        </div>



    </div>
@push('script')

@endpush

@endsection
