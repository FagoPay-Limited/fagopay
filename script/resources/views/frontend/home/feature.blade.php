@if(isset($data['headings']['heading.feature']))
    @php
    $heading = $data['headings']['heading.feature'];
    @endphp
    <!-- Feature Area -->
    <div class="feature-area section-padding-100-50" style="padding-top: 50px;">
        <div class="container">

            <div class="row">
                <!-- Single Features Area -->
                <div class="col-md-3 col-lg-3">
                    <div class="single-feature-area text-center mb-50">
                        <div class="features-icon">
                            <i class="fas fa-rss"></i>
                        </div>
                        <h4>Bill Payment</h4>
                        <p>A better way to top up airtime, data, pay electricity & cable bills</p>
                    </div>
                </div>

                <!-- Single Features Area -->
                <div class="col-md-3 col-lg-3">
                    <div class="single-feature-area text-center mb-50">
                        <div class="features-icon">
                            <i class="fas fa-piggy-bank"></i>
                        </div>
                        <h4>Send & Recieve</h4>
                        <p>Fast free to send & recieve money to any fagopay account.</p>
                    </div>
                </div>
                <!-- Single Features Area -->
                <div class="col-md-3 col-lg-3">
                    <div class="single-feature-area text-center mb-50">
                        <div class="features-icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <h4>Invoice Payments</h4>
                        <p>Get your invoice paid in just a few taps with instant settlement.</p>
                    </div>
                </div>
                
                <div class="col-md-3 col-lg-3">
                    <div class="single-feature-area text-center mb-50">
                        <div class="features-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <h4>QR Payments</h4>
                        <p>Take payments from anywhere via Payment Links or Qr Code.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature Area -->
@else
@endif
