@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="">
                              
                            <div class="">
                                <div class="row">
 

                                    <div class="col-lg-12">
                                        <div class="card border-primary my-2">
                                            <h5 class="card-header bg-primary  text-white">@lang('VPIN Vendor') </h5>
                                            <div class="card-body">
                                            <br>
                                                <div class="form-group">
                                                <label>VPIN Service Provider</label>
                                                    <select class="form-control border-radius-5" name="vendor">
                                                    <option @if($general->vpin_vendor == 'VTPass') selected @endif>VTPass</option>
                                                    <option  @if($general->vpin_vendor == 'Payscribe') selected @endif>Payscribe</option>
                                                    </select>
                                                </div>
                                                <br>
                                                <div class="form-group">
                                                <label>VPIN Discount <small><b>(%)</b></small></label>
                                                    <input class="form-control border-radius-5" value="{{$general->vpin_discount}}" name="vpin_discount">
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">@lang('Update Vendor')</button>
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
