@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                
                <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                        <thead>
                            <tr>
                                <th>@lang('#')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Categoory')</th>
                                <th>@lang('Reference ID')</th>
                                <th>@lang('Product Price')</th>
                                <th>@lang('Date Created')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($advert as $index)
                            @php
                            $category = App\Models\AdvertCatgeory::whereId($index->category)->first();
                            @endphp
                            <tr>
                                <td data-label="@lang('Game Name')">{{ $loop->iteration }}</td>
                                <td data-label="@lang('Game Name')">{{ $index->title }}</td>
                                <td data-label="@lang('Game Name')">{{ @$category->name }}</td>
                                <td data-label="@lang('Minimum Invest')">{{ $index->reference }}</td>
                                <td data-label="@lang('Maximum Invest')">{{ $general->cur_sym }} {{ number_format($index->amount,2) }}</td>
                                
                                <td data-label="@lang('Minimum Invest')">{{ date('d-F-Y h:i A',strtotime($index->created_at))  }}</td>
                                <td data-label="@lang('Status')">
                                    @if($index->status == 0)
                                    <span class="badge bg-danger">@lang('inactive')</span>
                                    @elseif($index->status == 1)
                                    <span class="badge bg-success">@lang('Running')</span>
                                    @elseif($index->status == 2)
                                    <span class="badge bg-primary">@lang('Disabled')</span>
                                    @else
                                    <span class="badge bg-danger">@lang('Rejected')</span>
                                    @endif
                                </td>
                                <td data-label="@lang('Action')">
                                    <a href="{{ route('admin.advert.view',$index->reference) }}" class="btn btn-sm btn-primary">Manage</a>
                                    @if($index->status == 0)
                                    <a href="{{ route('admin.advert.reject',$index->reference) }}" class="btn btn-sm btn-danger">Reject</a>
                                    @elseif($index->status == 1)
                                    <a href="{{ route('admin.advert.close',$index->reference) }}" class="btn btn-sm btn-warning">Disable</a>
                                    @elseif($index->status == 2 || $index->status == 3)
                                    <a href="{{ route('admin.advert.delete',$index->reference) }}" class="btn btn-sm btn-danger">Delete</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    {{ $advert->links('admin.partials.paginate') }}
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection