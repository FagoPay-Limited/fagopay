@extends('layouts.backend.app')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            
               <!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head> 
</html>
 
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                            <th>@lang('Id')</th>
                            <th>@lang('Icon')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Network Status')</th>
                                <!--
                                <th>@lang('Sim Host Slot')</th>
                                <th>@lang('Airtime Sim Host')</th>
                                <th>@lang('Internet Sim Host')</th>-->
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i = 1; @endphp
                            @forelse($category as $data)
                            <tr>
                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ __($i++) }}
                                    </span>
                                </td>
                                <td data-label="@lang('Name')">
                                <img src="{{ url('/')}}/uploads/bills/{{$data->symbol}}.jpg" alt="img" width="40" >
                                </td>

                               <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ __($data->name) }}
                                    </span>
                                </td>


                               


                                <td data-label="@lang('Status')">
                                    @if($data->status == 0)
                                        <span class="badge bg-danger">
                                            @lang('Disabled')
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            @lang('Enabled')
                                        </span>
                                    @endif
                                </td>
                                <!--
                                <td data-label="@lang('Slot')">
                                    @if($data->host_sim == 1)
                                        <span class="badge bg-primary">
                                            @lang('Sim 1')
                                        </span>
                                    @elseif($data->host_sim == 2)
                                        <span class="badge bg-secondary">
                                            @lang('Sim 2')
                                        </span>
                                    @endif
                                </td>
                                <td data-label="@lang('Status')">
                                    @if($data->airtime_sim_host == 0)
                                        <span class="badge bg-danger">
                                            @lang('Disabled')
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            @lang('Enabled')
                                        </span>
                                    @endif
                                </td>
                               
                                <td data-label="@lang('Status')">
                                    @if($data->internet_sim_host == 0)
                                        <span class="badge bg-danger">
                                            @lang('Disabled')
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            @lang('Enabled')
                                        </span>
                                    @endif
                                </td>
                                 -->

                                <td data-label="@lang('Action')">
                                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal{{$data->id}}">Edit</button>

                                </td>
                            </tr>


                            {{-- EDIT METHOD MODAL --}}
<div id="myModal{{$data->id}}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Network Type')</h5>

            </div>
            <form action="{{ route('admin.bills.network.update',$data->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-1">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" disabled class="form-control"  value="{{$data->name}}"  required>
                            </div>
                        </div>
                        <!--
                        <div class="col-lg-12">
                        <div class="form-group mb-1">
                            <label for="name">@lang('Airtime Vending USSD Code')</label>
                            <input type="text" name="airtime_vend_ussd" class="form-control"  value="{{$data->airtime_vend_ussd}}" >
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group mb-1">
                            <label for="name">@lang('Internet Vending USSD Code')</label>
                            <input type="text" name="internet_vend_ussd" class="form-control"  value="{{$data->internet_vend_ussd}}" >
                        </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-1">
                                <label for="name">@lang('Sim Host Server ID')</label>
                                <input type="text" name="vending_server_id" class="form-control"  value="{{$data->vending_server_id}}" >
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="form-group mb-1">
                                <label for="name">@lang('Sim Host API Key')</label>
                                <input type="text" name="vending_api_key" class="form-control"  value="{{$data->vending_api_key}}" >
                            </div>
                        </div>
 

                       
                        <div class="form-group col-md-12">
                            <label class="form-control-label font-weight-bold">@lang('SIM Host Slot')</label><br>
                            <small class="text-primary">Toggle to switch from sim 1 to 2</small>
                            <div class="form-check form-switch form-check-primary">
                            <input type="checkbox" class="form-check-input"  name="host_sim" @if($data->host_sim == 2) checked @endif id="host_sim" />
                            <label class="form-check-label" for="host_sim">
                            <span class="switch-icon-left">2</span>
                            <span class="switch-icon-right">1</span>
                            </label>
                        </div>
                        <br>

                        <div class="form-group col-md-12">
                            <label class="form-control-label font-weight-bold">@lang('Airtime SIM Host Service')</label>
                            <div class="form-check form-switch form-check-primary">
                            <input type="checkbox" class="form-check-input"  name="airtime_sim_host" @if($data->airtime_sim_host) checked @endif id="airtime_sim_host" />
                            <label class="form-check-label" for="airtime_sim_host">
                            <span class="switch-icon-left"><i data-feather="check-circle"></i></span>
                            <span class="switch-icon-right"><i data-feather="x-circle"></i></span>
                            </label>
                        </div>
                        <br>

                        <div class="form-group col-md-12">
                            <label class="form-control-label font-weight-bold">@lang('Internet Data SIM Host Service')</label>
                            <div class="form-check form-switch form-check-primary">
                            <input type="checkbox" class="form-check-input"  name="internet_sim_host" @if($data->internet_sim_host) checked @endif id="internet_sim_host" />
                            <label class="form-check-label" for="internet_sim_host">
                            <span class="switch-icon-left"><i data-feather="check-circle"></i></span>
                            <span class="switch-icon-right"><i data-feather="x-circle"></i></span>
                            </label>
                        </div>
                        <br>
                        -->
                        <div class="form-group col-md-12">
                                <label class="form-control-label font-weight-bold">@lang('Network Status')</label>
                                <div class="form-check form-switch form-check-primary">
                            <input type="checkbox" class="form-check-input"  name="status" @if($data->status) checked @endif id="status" />
                            <label class="form-check-label" for="status">
                            <span class="switch-icon-left"><i data-feather="check-circle"></i></span>
                            <span class="switch-icon-right"><i data-feather="x-circle"></i></span>
                            </label>
                        </div>
                        
                        

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn text-white btn-primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>


                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">Data Not Found</td>
                                </tr>
                            @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
            </div>
        </div>

    </div>
 

@endsection

@push('breadcrumb-plugins')

@endpush

@push('script')

@endpush
