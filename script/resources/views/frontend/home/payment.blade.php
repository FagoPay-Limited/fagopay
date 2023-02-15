@if(isset($data['headings']['heading.payment']))
    @php
        $heading = $data['headings']['heading.payment'];
    @endphp
    <!-- Our service Area -->
    <div class="our-service-area bg-gray-cu section-padding-100-50">
        <!-- Animation -->
        <div class="welcome-animation">
           
            <div class="bubble b_four d-none d-sm-block"></div>
            <div class="square-shape1 d-none d-sm-block"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="heading-title text-center" data-aos="fade-down" data-aos-anchor-placement="top-bottom">
                        <h2><span>-</span>Payment solutions<span>-</span></h2>
                    </div>
                </div>
            </div>

            <div class="row">
                 <div class="col-md-8">
                
                
                <div class="row">
                <!-- Single Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-area mb-50">
                        <div class="service-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div class="service-text">
                            <h4>
                                <a href="#">QR code payments</a>
                            </h4>
                            <p>Simple contactless payments with QR codes. Take payments from anywhere – scan and pay.</p>
                        </div>

                    </div>
                </div>

                <!-- Single Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-area mb-50">
                        <div class="service-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div class="service-text">
                            <h4>
                                <a href="#">Invoice payments</a>
                            </h4>
                            <p>Copy the Fagopay payment link on your invoices and get paid in just a few taps.</p>
                        </div>
                    </div>
                </div>

                <!-- Single Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-area mb-50">
                        <div class="service-icon">
                            <i class="fas fa-link"></i>
                        </div>
                        <div class="service-text">
                            <h4>
                                <a href="#">Payment links</a>
                            </h4>
                            <p>Generate a payment link to easily request payments via  messaging platform.</p>
                        </div>
                    </div>
                </div>

                <!-- Single Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-area mb-50">
                        <div class="service-icon">
                            <i class="fas fa-rss"></i>
                        </div>
                        <div class="service-text">
                            <h4>
                                <a href="#">Bills Payments</a>
                            </h4>
                            <p>A better way to top up & swap airtime, buy data, pay electricity & cable bills.</p>
                        </div>
                    </div>
                </div>

                <!-- Single Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-area mb-50">
                        <div class="service-icon">
                            <i class="far fa-credit-card"></i>
                        </div>
                        <div class="service-text">
                            <h4>
                                <a href="#">Virtual Cards</a>
                            </h4>
                            <p>Use our Virtual master/visa card to make payment on shopping platform.</p>
                        </div>
                    </div>
                </div>
                <!-- Single Service -->
                <div class="col-md-6 col-lg-4">
                    <div class="single-service-area mb-50">
                        <div class="service-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="service-text">
                            <h4>
                                <a href="#">API payments</a>
                            </h4>
                            <p>Add instant bank transfers to your checkout on your app or website.</p>
                        </div>
                    </div>
                </div>
            </div> </div>
            
            
            <div class="col-md-4">
            
            
            <div class="sloution-box-lft-content position-relative help-left-con wow fadeInRight">
                       
                        <figure class="mb-0">
                            <br><br>
                           <img src="{{ url('/') }}/frontend/png/help-left-img.png" alt="help-left-img">
                        </figure>
                     </div>
            
            
            
             </div>
            
            
            
            
            
        </div>
         </div>
    </div>
    <!-- Our service Area -->
@else
@endif
