<div class=" ">
    <div class="container-fluid">
        <div class="lol">
            <div class="row align-items-center">
                <div class="col-lg-12 text-right">
                    @yield('actions')
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->pin == null)

<div class="col-md-12">
    <div class="alert alert-danger" role="alert">
        It appears you have not set your transaction PIN. Please click <a  href="{{ route('user.setpin') }}" class="btn btn-primary btn-sm">Here</a> to set transaction PIN
    </div>
</div>
@endif
