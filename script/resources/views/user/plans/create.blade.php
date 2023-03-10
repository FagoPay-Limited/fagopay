@extends('layouts.user.master')

@section('title', __('Plan create'))

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.home.index') }}"><i class="fas fa-home"></i></a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Plan create') }}</li>
@endsection

@section('actions')
    <a href="{{ route('user.plans.index') }}" class="btn btn-sm btn-neutral">{{ __('View list') }}</a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0 font-weight-bolder">{{ __('Create New Plan') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('user.plans.store')}}" method="post" class="ajaxform_instant_reload repeater">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text" name="name" class="form-control" placeholder="{{ __("Name") }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">{{ user_currency()->symbol  }}</span>
                                </span>
                                    <input type="number" step="any" class="form-control" name="amount" placeholder="0.00">
                                </div>
                                <span class="form-text text-xs">{{ __('Leave empty to allow customers enter desired amount') }}</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <select class="form-control select" name="interval">
                                    <option value="">{{__('Select Interval')}}</option>
                                    <option value="1 Hour">{{__('Hourly')}}</option>
                                    <option value="1 Day">{{__('Daily')}}</option>
                                    <option value="1 Week">{{__('Weekly')}}</option>
                                    <option value="1 Month">{{__('Monthly')}}</option>
                                    <option value="4 Months">{{__('Quarterly')}}</option>
                                    <option value="6 Months">{{__('Every 6 Months')}}</option>
                                    <option value="1 Year">{{__('Yearly')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="number" name="limit" placeholder="{{ __("Number of times to charge a subscriber?") }}" class="form-control">
                                <span class="form-text text-xs">{{ __('Leave empty to charge subscriber indefinitely') }}</span>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="required">{{ __("Features") }}</h4>
                                <button data-repeater-create class="btn btn-primary btn-sm" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="card-body">
                                <div data-repeater-list="features">
                                    <div data-repeater-item class="input-group mb-3">
                                        <input type="text" name="title" id="title" class="form-control" placeholder="{{ __("Enter feature title") }}" required>
                                        <div class="input-group-append" data-repeater-delete>
                                            <button class="btn btn-danger btn-sm" type="button">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-neutral btn-block submit-button">
                                <i class="fas fa-save"></i>
                                {{ __('Create Plan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('user/plan.js') }}"></script>
@endpush
