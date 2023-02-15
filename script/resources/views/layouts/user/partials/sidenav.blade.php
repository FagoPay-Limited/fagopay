@php
    $logo = get_option('logo_setting');
@endphp

  <!-- Sidebar main menu -->
      <div class="sidebar-wrap  sidebar-pushcontent " >
        <!-- Add overlay or fullmenu instead overlay -->
        <div class="closemenu text-muted">Close Menu</div>
        <div class="sidebar dark-bg ">

        <div class=" border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                <div class="logo-small">
                            <img src="{{ $logo['logo'] ?? null }}" alt="{{ config('app.name') }}" class="dark-version-logo">
                            
                        </div>
                                </div>
                                
                                <div class="col-auto" id="go">
                              <button href="javascript:void(0)" class="btn  menu-btn btn-44 btn-light">
                                        <i class="bi bi-box-arrow-left"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                    </div>


            <!-- user information -->
           
<br>
            <!-- user emnu navigation -->
            <div class="row ">
                <div class="col-12">
                    <ul class="nav nav-pills">
                        
                         <li class="nav-item">
                            <a class="nav-link @if(route('user.home.index')==url()->current()) active @endif" href="{{route('user.home.index')}}">
                                <div class="avatar avatar-40 rounded "><i class="fad fa-house-user"></i></div>
                              <span class="col">{{__('Dashboard')}}</span>
                            </a>
                          </li> 
                          
                          
                        
              <!--            <li class="nav-item">
                 <a class="nav-link @if(route('user.deposits.index')==url()->current()) active @endif" href="{{route('user.deposits.index')}}">
                           <div class="avatar avatar-40 rounded "><i class="fad fa-house-user"></i></div>
                            <span class="col">{{ __('Deposit') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(route('user.payouts.index')==url()->current()) active @endif" href="{{route('user.payouts.index')}}">
                           <div class="avatar avatar-40 rounded "><i class="fad fa-house-user"></i></div>
                            <span class="col">{{ __('Withdraw') }}</span>
                        </a>
                    </li>-->
                        <li class="nav-item">
                            <a class="nav-link @if(route('user.transactions.index')==url()->current()) active @endif" href="{{route('user.transactions.index')}}">
                                <div class="avatar avatar-40 rounded "><i class="fad fa-credit-card"></i></div>
                              <span class="col">{{__('Transactions')}}</span>
                            </a>
                          </li> 
</ul>
                        </div>
            </div>
            <div class="row " >
                <div class="col-12">
                    <ul class="nav nav-pills" >
                      
                        <h5 class="navbar-heading p-0 text-muted">{{__('BILLS PAYMENT')}}</h5>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#bill"data-bs-toggle="dropdown" role="button" aria-expanded="fadse" aria-controls="bill">
                                <div class="avatar avatar-40 rounded "><i class="fad fa-gift"></i></div>
                                <div class="col">{{__('Bills Payments')}}</div>
                                <div class="arrow"><i class="bi bi-plus plus"></i> <i class="bi bi-dash minus"></i>
                                </div>
                            </a>
                            <ul class="dropdown-menu" id="bill">
                            <li class="">
                                <a class="dropdown-item nav-link" href="{{route('user.airtime')}}">{{__('Buy Airtime')}}</a></li>

                                <li class="">
                                <a class="dropdown-item nav-link" href="{{route('user.bills.swapairtime')}}">{{__('Airtime Swap')}}</a></li>
                                
                                <li class="">
                                <a href="{{route('user.bills.bulkairtime')}}" class="dropdown-item nav-link">{{__('Bulk Airtime')}}</a>
                                </li>      
                                
                                
                                <li class="">
                                <a href="{{route('user.bills.vpin')}}" class="dropdown-item nav-link">{{__('VPin Vending')}}</a>
                                </li> 
                                
                                <li class="">
                                <a href="{{route('user.internet')}}" class="dropdown-item nav-link">{{__('Buy Data')}}</a>
                                </li> 
                                
                                 <li class="">
                                <a href="{{route('user.cabletv')}}" class="dropdown-item nav-link">{{__('TV Subscription')}}</a>
                                </li> 
                                
                                 <li class="">
                                <a href="{{route('user.utility')}}" class="dropdown-item nav-link">{{__('Electricity')}}</a>
                                </li> 
                                
                                                              

                            </ul>
                        </li>
                        
                        
                          
                          
                     
                        
                        
                        <br>
                        <h5 class="navbar-heading p-0 text-muted">{{__('PAYMENTS')}}</h5>    
                        
                         
                           <li class="nav-item">
                        <a class="nav-link @if(route('user.qr-payments.index')==url()->current()) active @endif" href="{{route('user.qr-payments.index')}}">
                            <div class="avatar avatar-40 rounded"><i class="fad fa-qrcode"></i></div>
                            <span class="col">{{ __('Qr Payments') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(route('user.single-charges.index')==url()->current()) || route('user/single-charges*')==url()->current()) active @endif" href="{{route('user.single-charges.index')}}">
                            <div class="avatar avatar-40 rounded"><i class="fad fa-link"></i></div>
                            <span class="col">{{ __('Payment Link') }}</span>
                        </a>
                    </li>
                    
                      <li class="nav-item">
                        <a class="nav-link @if(route('user.invoices.index')==url()->current()) active @endif" href="{{route('user.invoices.index')}}">
                             <div class="avatar avatar-40 rounded"><i class="fad fa-envelope"></i></div>
                            <span class="col">{{ __('Invoice') }}</span>
                        </a>
                    </li>
                    
              <li class="nav-item">
                <a class="nav-link @if(route('user.transfers.index')==url()->current()) active @endif" href="{{route('user.transfers.index')}}">
                    <div class="avatar avatar-40 rounded"><i class="fad fa-random"></i></div>
                  <span class="col">{{__('Transfer Money')}}
                  </span>
                </a>
              </li>
              
                          <li class="nav-item">
                            <a class="nav-link @if(route('user.request-money.index')==url()->current()) active @endif" href="{{route('user.request-money.index')}}">
                                <div class="avatar avatar-40 rounded"><i class="fad fa-handshake"></i></div>
                              <span class="col">{{__('Request Money')}}
                              </span>
                            </a>
                          </li> 
                          
                         
                  

                          
                    </ul>
                </div>
            </div>

            <div class="row ">
                <div class="col-12">
                    <ul class="nav nav-pills">
                         
                        
                    <li class="nav-item">
                            <a class="nav-link @if(route('user.websites.index')==url()->current()) active @endif" href="{{route('user.websites.index')}}">
                                <div class="avatar avatar-40 rounded"><i class="fad fa-code"></i></div>
                              <span class="col">{{__('API Integration')}}</span>
                            </a>
                          </li> 
                    
                          <li class="nav-item">
                            <a class="nav-link @if(route('user.supports.index')==url()->current() || route('user.supports.index')==url()->current()) active @endif" href="{{route('user.supports.index')}}">
                                <div class="avatar avatar-40 rounded"><i class="fad fa-flag"></i></div>
                              <span class="col">{{__('Disputes')}}</span>
                            </a>
                          </li> 

</ul>
                        </div>
            </div>






        </div>
    </div>
    <!-- Sidebar main menu ends -->
    
    
    
    
    
    
    
<!-- Sidenav -->
