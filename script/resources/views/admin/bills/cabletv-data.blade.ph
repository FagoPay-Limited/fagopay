@extends('layouts.backend.app')

@section('content')
@push('script')
@endpush

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Modal Example</h2>
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>

</body>
</html>


    <div class="row">
        <div class="col-lg-12">
 
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                            <tr>
                            <th>@lang('Id')</th>
                            <th>@lang('Icon')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Plan')</th>
                                <th>@lang('Cost')</th>
                                <th>@lang('Status')</th>
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
                                <img src="{{ url('/')}}/uploads/bills/{{$data->networkcode}}.jpg" alt="img" width="40" >
                                </td>

                               <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ __($data->name) }}
                                    </span>
                                </td>
                                <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ __($data->plan) }}
                                    </span>
                                </td> <td data-label="@lang('Name')">
                                    <span class="font-weight-bold">
                                        {{ __($data->cost) }}
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

                                <td data-label="@lang('Action')">
                                    <a href="#0"
                                    data-id='{{ $data->id }}'
                                    data-name='{{ $data->name }}'
                                    data-code='{{ $data->airtime_vend_ussd }}'
                                    data-note='{{ $data->conversion_note }}'
                                    data-status='{{ $data->status }}'
                                    data-type='{{ $data->type }}'
                                    class="btn btn-sm btn-primary text-white icon-btn"
                                    data-toggle="tooltip"
                                    title="@lang('Edit')"
                                    data-original-title="@lang('Edit')"
                                    data-bs-toggle="modal" data-bs-target="#editModal{{$data->id}}"
                                    >
                                        Edit
                                    </a>
                                </td>
                            </tr>

{{-- EDIT METHOD MODAL --}}
<div id="editModal{{$data->id}}" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('Edit Cable TV Bundle')</h5>

            </div>
            <form action="{{ route('admin.bills.cabletv.update',$data->id) }}" method="POST"  enctype="multipart/form-data">
                @csrf
                <div class="modal-body">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group mb-1">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" class="form-control"  value="{{$data->name}}"  required>
                            </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group mb-1">
                            <label for="name">@lang('Data Code')</label>
                            <input type="text" name="plan" class="form-control" disabled value="{{$data->plan}}" >
                        </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group mb-1">
                                <label for="name">@lang('Amount')</label>
                                <input type="text" name="cost" class="form-control"  value="{{$data->cost}}" >
                            </div>
                        </div>
 
 
 

                        <div class="form-group col-md-12">
                                <label class="form-control-label font-weight-bold">@lang('Status')</label>
                                <div class="form-check form-switch form-check-primary">
                            <input type="checkbox" class="form-check-input"  name="status" @if($data->status) checked @endif id="status" />
                            <label class="form-check-label" for="status">
                            <span class="switch-icon-left"><i data-feather="plus"></i></span>
                            <span class="switch-icon-right"><i data-feather="x"></i></span>
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
                <div class="card-footer py-4">
            {{ $category->links() }}
        </div>
            </div>
        </div>

    </div>
 

@endsection

@push('breadcrumb-plugins')

@endpush

@push('script')

@endpush
