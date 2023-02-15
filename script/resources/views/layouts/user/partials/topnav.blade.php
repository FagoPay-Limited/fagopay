<header class="header position-fixed">
            <div class="row">
                <div class="col-auto">
                    <a href="javascript:void(0)" target="_self" class="btn btn-light btn-44 menu-btn">
                        <i class="bi bi-list"></i>
                    </a>
                </div>
                <div class="col align-self-center text-center">
                    
                </div>
               
                <div class="col-auto ">
      
      <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle" style="width: 33px; height: 33px;">
                                <img alt="{{ auth()->user()->name }}" src="{{ avatar() }}">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm font-weight-bold">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    </a>
      <div class="dropdown-menu cool dropdown-menu-right">
                
         <a href="{{ route('user.profiles.index') }}" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>{{ __('My profile') }}</span>
                        </a>
                        <a href="{{ route('user.kyc-verifications.index') }}" class="dropdown-item">
                            <i class="ni ni-lock-circle-open"></i>
                            <span>{{ __('Kyc Verification') }}</span>
                        </a>
                        <a href="{{ route('user.api-keys.index') }}" class="dropdown-item">
                            <i class="ni ni-settings-gear-65"></i>
                            <span>{{ __("API Keys") }}</span>
                        </a>
                        <a href="{{ route('user.supports.index') }}" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            <span>{{ __('Support') }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logoutForm').submit()">
                            <i class="fa fa-sign-out-alt"></i>
                            <span>{{ __('Logout') }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="post" id="logoutForm">
                            @csrf
                        </form>
      </div>
 
</div>
            </div>
        </header>
        