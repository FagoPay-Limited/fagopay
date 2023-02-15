@extends('layouts.backend.app')

@section('content')

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
                                <th>@lang('Network Status')</th>
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
                                    @if($data->airtime_convert == 0)
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
                                    <a href="{{ route('admin.bills.airtime.swap.edit',$data->symbol) }}"
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
                                     >
                                        Edit
                                    </a>
                                </td>
                            </tr>


                           


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
