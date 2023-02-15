@extends('admin.layouts.app')

@section('panel')
@push('style')

<link rel="stylesheet" type="text/css" href="{{ asset($activeTemplateTrue. 'app-assets/css/plugins/forms/form-file-uploader.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset($activeTemplateTrue. 'app-assets/vendors/css/file-uploaders/dropzone.min.css')}}">
@endpush


<div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
 
			<form action=""  method="post" id="dpz-single-file" enctype="multipart/form-data">
				@csrf
				<div class="card-body">
				@if($advert->status == 0)
                                    <span class="badge bg-danger">@lang('inactive')</span>
                                    @elseif($advert->status == 1)
                                    <span class="badge bg-success">@lang('Running')</span>
                                    @elseif($advert->status == 2)
                                    <span class="badge bg-info">@lang('Closed')</span>
                                    @else
                                    <span class="badge bg-danger">@lang('Rejected')</span>
                                    @endif

				<center><img src="{{ getImage(imagePath()['advert']['path'].'/'.$advert->image,imagePath()['advert']['size']) }}" alt="img" width="100" ></center>

					<div class="row">
					
 
					<div class="form-group mb-1">
                                            <label for="formFile" class="form-label">@lang('Supported files:') <b>@lang('jpeg, jpg, png')</b>. @lang('Image will be resized into') <b>{{ imagePath()['game']['size'] }}@lang('px')</b></label>
                                            <input class="form-control" type="file" name="image" id="formFile" />
                                     
                        </div>

						 
								<div class="col-md-12">
									<div class="form-group mb-1">
										<label>@lang('Advert Title')</label>
										<input type="text" name="title" class="form-control" placeholder="@lang('Advert Title')" value="{{ $advert->title }}" required>
									</div>
								</div>


								<div class="col-md-12">
									<div class="form-group mb-1">
										<label>@lang('Subtitle')</label>
										<input type="text" name="sub_title" class="form-control"  value="{{ $advert->sub_title }}">
									</div>
								</div>


						 
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label>@lang('Expiry Date') <small><b>{{ date('d-F-Y h:i A',strtotime($advert->expire_at))  }}</b></small></label>
										<input type="date" name="expire_at" class="form-control"  value="{{ $advert->expire_at }}">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group mb-1">
										<label>@lang('Product Price')</label>
										<input type="number" name="amount" class="form-control"  value="{{ $advert->amount }}">
									</div>
								</div>

								<div class="col-md-8">
									<div class="form-group mb-1">
										<label>@lang('Advert Catgeory')</label>
										<select type="text" name="category" class="form-control" required>
											@foreach($category as $data)
											<option  @if($advert->category == $data->id) selected @endif value="{{$data->id}}"> {{$data->name}}</option>
											@endforeach
										</select>
									</div>
								</div> 
								@if($advert->status == 2 || $advert->status == 0 || $advert->status == 3)
								<div class="form-group col-lg-4 col-sm-6 col-md-4 mb-1">
																	<label class="form-control-label font-weight-bold">@lang('Activate')</label>
																	<div class="form-check form-switch form-check-primary">
													<input type="checkbox" class="form-check-input" name="status"  @if($advert->status == 1) checked @endif id="status" />
													<label class="form-check-label" for="status">
													<span class="switch-icon-left"><i data-feather="plus"></i></span>
													<span class="switch-icon-right"><i data-feather="x"></i></span>
													</label>
												</div>
							</div>
							@endif

 


						</div>
							<br>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group mb-1">
										<label>@lang('Game Instruction')</label>
										<textarea rows="5" class="form-control nicEdit" name="description">@php echo $advert->description @endphp</textarea>
									</div>
								</div>
							</div>
							<br>


							</div>

				<div class="card-footer">
					<button type="submit" class="btn btn-success btn-lg btn-block">@lang('Update')</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
 

@push('script')

@endpush
@endsection

@push('breadcrumb-plugins')
<a href="{{ route('admin.game.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-backward"></i> @lang('Go Back') </a>
@endpush