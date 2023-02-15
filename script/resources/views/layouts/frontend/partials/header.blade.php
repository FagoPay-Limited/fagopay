@php
    $logo = get_option('logo_setting');
@endphp

<!-- Header Area Start -->
<div class="header-and-banner-con w-100 overflow">
         <div class="header-and-banner-inner-con">
             
             
<div id="___gatsby"><div style="outline:none" id="gatsby-focus-wrapper"><div class=""><div class="kuda-entry--wrap">
                 
                 <header class=" header-main-con z-index-1 kuda-header align-center flex"><div class="flex justify-between align-center column--100 kuda-header--wrap"><div class="kuda-header--main flex align-center"><a aria-current="page" class="kuda-brand" href="{{url('/')}}">
                     
                     <img src="{{ $logo['logo'] ?? null }}" alt="{{ config('app.name') }}" class="dark-version-logo">
                     
                     </a>
                     <ul class="kuda-menu--wrap flex align-center">
                         
                         <li class="kuda-nav--menu"><a href="{{url('/')}}/personal" class="color-primary">Home</a></li>
                         
                         <li class="kuda-nav--menu"><a href="{{url('/')}}/about" class="color-primary">About&nbsp;Us</a></li>
                         
                         <li class="kuda-nav--menu" data-toggle="dropdown"><p class="color-primary no-link">Products<span class="dropDown"><svg width="9" height="6" viewBox="0 0 9 6" fill="none"><path d="M4.5 6L0 0H9L4.5 6Z" fill="#fff"></path></svg></span></p><div class="dropdown-menu">
                             <ul class="kuda-dropdown--menu drop-min--width">
                                 
                                 <li><a href="{{url('/')}}/nfc" class="menu-link"><span class="menu-link--icon"></span>Fago NFC Card</a></li>
                                 
                                 <li><a href="{{url('/')}}/teens" class="menu-link"><span class="menu-link--icon"></span>Fago Teen Card</a></li>
                                 
                                 <li><a href="#" class="menu-link"><span class="menu-link--icon"></span>Bill Payments</a></li>
                                 
                                 <li><a href="#" class="menu-link"><span class="menu-link--icon"></span>Invoice Payments</a></li>
                                 
                                 <li><a href="#" class="menu-link"><span class="menu-link--icon"></span>QR Code Payments</a></li>
                                 
                                 <li><a href="#" class="menu-link"><span class="menu-link--icon"></span>Airtime Swap</a></li>
                                 
                                
                                 
                                
                                 
                                </ul>
                                </div></li>
                                
                                <li class="kuda-nav--menu"><a href="{{url('/')}}/business" class="color-primary">Business<span class="coming-soon">Pro</span></a></li>
                                
                                
                                
                                <li class="kuda-nav--menu" data-toggle="dropdown"><p class="color-primary no-link">Community<span class="dropDown"><svg width="9" height="6" viewBox="0 0 9 6" fill="none"><path d="M4.5 6L0 0H9L4.5 6Z" fill="#fff"></path></svg></span></p>
                                <div class="dropdown-menu">
                                    <ul class="kuda-dropdown--menu">
                                        <li><a href="{{url('/')}}/blog"  rel="noopener noreferrer" class="menu-link">Blog</a></li>
                                        <li><a href="{{url('/')}}/career"  rel="noopener noreferrer" class="menu-link">Join Our Team</a></li>
                                        </ul></div></li>
                                
                                <li class="kuda-nav--menu" data-toggle="dropdown">
                                    <p class="color-primary no-link" to="/help">Help<span class="dropDown"><svg width="9" height="6" viewBox="0 0 9 6" fill="none"><path d="M4.5 6L0 0H9L4.5 6Z" fill="#fff"></path></svg></span></p>
                                    <div class="dropdown-menu global-overlay">
                                        <ul class="kuda-dropdown--menu">
                                            <li><a href="{{url('/')}}/faq"  rel="noopener noreferrer" class="menu-link">FAQs</a></li>
                                           
                                            <li><a href="{{url('/')}}/contact" class="menu-link">Contact Us</a></li>
                                            
                                            </ul></div></li>
                                            
                                            
                                            </ul>
                                            
                                            
                                            </div><div class="kuda-header--extras flex align-center">
                         
                         
                     <a href="{{url('/')}}/login" class="kuda-cta">Login</a>
                     
                     <a href="{{url('/')}}/register" class="kuda-cta">Sign Up</a>
                     </div>
                     
                     <div class="kuda-nav--menu has-left--margin" data-toggle="dropdown"><div class="color-primary no-link flex align-center" to="/help"><div class="dropDown flex global-drop"><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCAzMCAzMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBvcGFjaXR5PSIwLjMiIGN4PSIxNC45OTkzIiBjeT0iMTUiIHI9IjE1IiBmaWxsPSIjMDA4NzUxIi8+CjxtYXNrIGlkPSJtYXNrMF80MTkxOV80NTg3IiBzdHlsZT0ibWFzay10eXBlOmFscGhhIiBtYXNrVW5pdHM9InVzZXJTcGFjZU9uVXNlIiB4PSI2IiB5PSI3IiB3aWR0aD0iMTgiIGhlaWdodD0iMTYiPgo8cmVjdCB4PSI2LjkxMzMzIiB5PSI3LjI5NzEyIiB3aWR0aD0iMTYuMTcyNCIgaGVpZ2h0PSIxNS40MDIzIiByeD0iMyIgZmlsbD0iI0U5NEQxRSIvPgo8L21hc2s+CjxnIG1hc2s9InVybCgjbWFzazBfNDE5MTlfNDU4NykiPgo8ZyBjbGlwLXBhdGg9InVybCgjY2xpcDBfNDE5MTlfNDU4NykiPgo8cGF0aCBkPSJNMC4zMjUxOTUgNC4xMzU1SDI5LjUxNDRWMjYuMDI3NEgwLjMyNTE5NVY0LjEzNTVaIiBmaWxsPSIjMDA4NzUxIi8+CjxwYXRoIGQ9Ik0xMS4xODk3IDQuMDU0NDRIMTkuMjk3OFYyNS45NDYzSDExLjE4OTdWNC4wNTQ0NFoiIGZpbGw9IndoaXRlIi8+CjwvZz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF80MTkxOV80NTg3Ij4KPHJlY3Qgd2lkdGg9IjI5LjE4OTIiIGhlaWdodD0iMjEuODkxOSIgZmlsbD0id2hpdGUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMzI1MTk1IDQuMTM1NSkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K" alt="logo"></div></div><div class="dropdown-menu"><div class="flex kuda-global--menu kuda-global--menu--mobile">
                         
                         <div class="global-menu--wrap"><div class="global-illustration title-bottom--spacing"><img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMzAiIGhlaWdodD0iMzAiIHZpZXdCb3g9IjAgMCAzMCAzMCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPGNpcmNsZSBvcGFjaXR5PSIwLjMiIGN4PSIxNC45OTkzIiBjeT0iMTUiIHI9IjE1IiBmaWxsPSIjMDA4NzUxIi8+CjxtYXNrIGlkPSJtYXNrMF80MTkxOV80NTg3IiBzdHlsZT0ibWFzay10eXBlOmFscGhhIiBtYXNrVW5pdHM9InVzZXJTcGFjZU9uVXNlIiB4PSI2IiB5PSI3IiB3aWR0aD0iMTgiIGhlaWdodD0iMTYiPgo8cmVjdCB4PSI2LjkxMzMzIiB5PSI3LjI5NzEyIiB3aWR0aD0iMTYuMTcyNCIgaGVpZ2h0PSIxNS40MDIzIiByeD0iMyIgZmlsbD0iI0U5NEQxRSIvPgo8L21hc2s+CjxnIG1hc2s9InVybCgjbWFzazBfNDE5MTlfNDU4NykiPgo8ZyBjbGlwLXBhdGg9InVybCgjY2xpcDBfNDE5MTlfNDU4NykiPgo8cGF0aCBkPSJNMC4zMjUxOTUgNC4xMzU1SDI5LjUxNDRWMjYuMDI3NEgwLjMyNTE5NVY0LjEzNTVaIiBmaWxsPSIjMDA4NzUxIi8+CjxwYXRoIGQ9Ik0xMS4xODk3IDQuMDU0NDRIMTkuMjk3OFYyNS45NDYzSDExLjE4OTdWNC4wNTQ0NFoiIGZpbGw9IndoaXRlIi8+CjwvZz4KPC9nPgo8ZGVmcz4KPGNsaXBQYXRoIGlkPSJjbGlwMF80MTkxOV80NTg3Ij4KPHJlY3Qgd2lkdGg9IjI5LjE4OTIiIGhlaWdodD0iMjEuODkxOSIgZmlsbD0id2hpdGUiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDAuMzI1MTk1IDQuMTM1NSkiLz4KPC9jbGlwUGF0aD4KPC9kZWZzPgo8L3N2Zz4K" alt="logo"></div><div><div><p class="text-normal color-black title-bottom--spacing">We’re currently operating in Nigerian for now.</p></div></div></div>
                     
                     
                   
             </div></div></div>
             
           <div id="openn" class="mobile-toggle">
                 <div class="kuda-hamburger">
                     <div class="kuda-hamburger--inner">
                         
                         
                         
                     </div></div></div>
           
             </div>
             
             
             <div class="menuu menuu2 ">
          <div class="mobile-container"><div class="kuda-menu--wrap flex align-center"><div class="kuda-footer--nav flex flex-column"><div class="kuda-mobile--brand"><a aria-current="page" class="kuda-brand" href="/">
              
               <img src="{{url('/')}}/uploads/1/22/11/6363dc4cc83bc0311221667488844.png" width="110"></a>
              
              <span id="closee" class=" closeMenu animated fadeIn"><svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="1.61414" y="0.500275" width="21" height="2" rx="1" transform="rotate(45 1.61414 0.500275)" fill="#40196D"></rect><rect x="0.614136" y="15.5003" width="21" height="2" rx="1" transform="rotate(-45 0.614136 15.5003)" fill="#40196D"></rect></svg></span>
              
              </div>
              
              <div class="kuda-menu--actions flex">
                  
                   @if(Auth::check())
                <a href="{{ Auth::user()->role == 'user' ? route('user.home.index') : route('admin.dashboard.index') }}" class="kuda-mobile--action kuda-cta1 mr-3">
                    {{ __('Dashboard') }}
                </a>
                @else
                    <a href="{{ route('login') }}" class="kuda-mobile--action kuda-cta1 mr-3">
                        {{ __('Login') }}
                    </a>
                    
                    <a href="{{ route('register') }}" class="kuda-mobile--action kuda-cta1 mr-3">
                        {{ __('SignUp') }}
                    </a>
                @endif
                
                  
                  
                  <a href="{{url('/')}}/business" class="kuda-mobile--action kuda-cta1 kuda-cta-v2">&nbsp;&nbsp;&nbsp;Business<span class="coming-soon">Pro</span>&nbsp;&nbsp;&nbsp;</a></div>
              
              <div class="kuda-mobile--navWrap ">
                  <div class="nav-col--wrap flex flex-wrap justify-content-between">
                      <div class="kuda-footer--col">
                          <div>
                              <p class="footer-header text-bold ">Products</p>
                              <ul class="kuda-footer--menu color-black">
                                  
                                   <li><a href="{{url('/')}}/wallet" class="flex align-center "> <span class="menu-link--icon"><svg width="37" height="38" viewBox="0 0 37 38" fill="none"><circle cx="18.5" cy="18.7012" r="18.5" fill="#420d36"></circle><circle cx="17.1547" cy="13.1869" r="3.18693" fill="white"></circle><path d="M25.183 18.097H24.7104C24.3784 17.0684 23.6927 16.057 22.9213 15.3056V12.9612C22.9213 12.8905 22.8469 12.8328 22.7761 12.8328C22.0923 12.8328 21.4759 13.1603 21.0895 13.6656C20.9829 15.6242 19.3516 17.1849 17.367 17.1849C16.1847 17.1849 15.1278 16.6302 14.4451 15.7685C14.1859 16.0488 13.9513 16.3531 13.748 16.6783C13.7406 16.6876 13.732 16.6957 13.7252 16.7054C13.6116 16.8734 13.4231 16.9734 13.2213 16.9734C12.8864 16.9734 12.614 16.7012 12.614 16.3664C12.614 16.1063 12.7795 15.8751 13.0257 15.7915C13.2274 15.723 13.3353 15.5042 13.2668 15.3023C13.1986 15.1009 12.9798 14.9929 12.7779 15.0614C12.2189 15.2512 11.843 15.7757 11.843 16.3662C11.843 17.1254 12.4598 17.7427 13.2184 17.7442C12.9656 18.4114 12.8053 19.1338 12.8053 19.8885C12.8053 21.7882 13.6636 23.5974 15.2065 24.742V26.164C15.2065 26.5992 15.6028 26.969 16.038 26.969H16.5887C17.024 26.969 17.3924 26.5992 17.3924 26.164V25.7688C18.421 26.0272 19.4496 26.0272 20.3497 25.7688V26.164C20.3497 26.5992 20.7787 26.969 21.2139 26.969H21.7644C22.1995 26.969 22.5355 26.5992 22.5355 26.164V24.742C23.5641 23.9714 24.3381 22.8545 24.7104 21.6973H25.183C25.6181 21.6973 26.0072 21.3101 26.0072 20.875V18.9022C26.0072 18.4668 25.6181 18.097 25.183 18.097ZM21.4121 18.8564C20.9527 18.8564 20.5802 18.4841 20.5802 18.0245C20.5802 17.5651 20.9526 17.1924 21.4121 17.1924C21.8717 17.1924 22.2443 17.565 22.2443 18.0245C22.2442 18.4842 21.8715 18.8564 21.4121 18.8564Z" fill="#fff"></path></svg></span>Fago Wallet</a></li>
                                 
                                 <li><a href="{{url('/')}}/nfc" class="flex align-center"><span class="menu-link--icon"><svg width="37" height="38" viewBox="0 0 37 38" fill="none"><circle cx="18.5" cy="18.7012" r="18.5" fill="#420d36"></circle><rect x="9.99951" y="12.8003" width="17" height="12" rx="1.5" fill="#fff" stroke="#DFE3FF"></rect><path d="M26.5 15H10.5V17H26.5V15Z" fill="white"></path></svg></span>Fago NFC Card</a></li>
                                 
                                 <li><a href="{{url('/')}}/teens" class="flex align-center"><span class="menu-link--icon"><svg width="37" height="38" viewBox="0 0 37 38" fill="none"><circle cx="18.5" cy="18.7012" r="18.5" fill="#420d36"></circle><rect x="9.99951" y="12.8003" width="17" height="12" rx="1.5" fill="#fff" stroke="#DFE3FF"></rect><path d="M26.5 15H10.5V17H26.5V15Z" fill="white"></path></svg></span>Fago Teens Card</a></li>
                                 
                                
                               
                               </ul></div></div>
                               
                               <div class="kuda-footer--col kuda-company--column">
                                   <div><p class="footer-header text-bold ">Community</p>
                                   <ul class="kuda-footer--menu color-black">
                                       <li><a href="{{url('/')}}/about" >About Us</a></li>
                                       <li><a href="{{url('/')}}/career" >Join Our Team</a></li>
                                       <li><a href="{{url('/')}}/blog" >Blog</a></li>
                                       </ul></div></div>
                               
                               <div class="kuda-footer--col kuda-company--column">
                                   <div><p class="footer-header text-bold">Help</p>
                                   <ul class="kuda-footer--menu color-black">
                                       <li><a href="{{url('/')}}/faq">FAQs</a></li>
                                       
                                       <li><a href="{{url('/')}}/contact">Contact Us</a></li>
                                       </ul></div></div>
                               
                               </div></div></div></div></div></div>
                               
                               </header>
             
             </div><div></div>
             
             
             </div></div></div>


<!-- header-end -->
