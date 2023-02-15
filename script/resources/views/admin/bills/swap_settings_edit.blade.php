@extends('layouts.backend.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="payment-method-item">
                            <div class="payment-method-header">
                                <div class="thumb">
                                 <div class="avatar avatar-xl">
              <img src="{{ url('/')}}/uploads/bills/{{$network->symbol}}.jpg" alt="avatar" />

            </div> 
                                </div>
                                     
                                </div>
                            </div>
                            <br>
                            <div class="payment-method-body">
                                <div class="row">

                                <div class="form-group col-md-12">
                            <label class="form-control-label font-weight-bold">@lang('Airtime Conversion')</label><br>
                            <small class="text-primary">Toggle to enable or diable airtime conversion for {{$network->name}}</small>
                            <div class="form-check form-switch form-check-primary">
                            <input type="checkbox" class="form-check-input"  name="airtime_convert" @if($network->airtime_convert == 1) checked @endif id="airtime_convert" />
                            <label class="form-check-label" for="airtime_convert">
                            <span class="switch-icon-left"><i data-feather="check-circle"></i></span>
                            <span class="switch-icon-right"><i data-feather="x-circle"></i></span>
                            </label>
                        </div>
                                     

                                    <div class="col-lg-12">
                                        <div class="card border-primary my-2">
                                            <h5 class="card-header bg-primary  text-white">@lang('Airtime Swap Instruction') </h5>
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <textarea rows="5" class="form-control border-radius-5" name="note">{{ $network->conversion_note}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="card border-primary">

                                            <h5 class="card-header bg-primary  text-white">@lang('Phone Numbers')
                                                <button type="button" class="btn btn-sm btn-outline-light float-right addUserData">
                                                    <i class="la la-fw la-plus"></i>@lang('Add New Number')
                                                </button>
                                            </h5>


                                            <div class="card-body">
                                                <div class="row addedField">

                                                        @foreach($numbers as $v)
                                                            <div class="col-md-12 user-data">
                                                            <br>
                                                                <div class="form-group">
                                                                    <div class="input-group mb-md-0 mb-4">
                                                                        <div class="col-md-10">
                                                                            <input name="field_name[]" class="form-control" type="text" value="{{$v->phone}}" required placeholder="@lang('Phone Number')">
                                                                        </div> 
                                                                      
                                                                        <div class="col-md-2  text-right">
                                                                            <span class="input-group-btn">
                                                                                <button class="btn btn-danger btn-md removeBtn" type="button">
                                                                                <i class="fa fa-trash"></i>
                                                                                </button>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">@lang('Save Numbers')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>
    </div>

@endsection

 

@push('script')
    <script>
        (function ($) {
            "use strict";

            $('input[name=currency]').on('input', function () {
                $('.currency_symbol').text($(this).val());
            });
            $('.currency_symbol').text($('input[name=currency]').val());

            $('.addUserData').on('click', function () {
                var html = `
                <div class="col-md-12 user-data">
                <br>
                    <div class="form-group">
                        <div class="input-group mb-md-0 mb-4">
                            <div class="col-md-10">
                                <input name="field_name[]" class="form-control" type="text" required placeholder="@lang('Phone Number')">
                            </div>
                             
                            <div class="col-md-2 mt-md-0 mt-2 text-right">
                                <span class="input-group-btn">
                                    <button class="btn btn-danger btn-lg removeBtn w-100" type="button">
                                        Remove
                                    </button>
                                </span>
                            </div>
                             
                        </div>
                    </div>
                </div>`;

                $('.addedField').append(html);
            });


            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.user-data').remove();
            });

            @if(old('currency'))
            $('input[name=currency]').trigger('input');
            @endif
        })(jQuery);


    </script>
@endpush
