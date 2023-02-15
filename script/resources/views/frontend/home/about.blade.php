@if(isset($data['headings']['heading.about']))
    @php
        $heading = $data['headings']['heading.about'];
    @endphp
    <!-- About Us Area -->
    <div class="about-us-area section-padding-0-50">
        <div class="container">
            <div class="row align-items-center">
                <!-- About Text -->
                <div class="col-lg-7 col-xl-6">
                    <div class="about-us-text mb-50">
                        <h2><span>-</span> Manage Your Finances The Easy Way</h2>
                        <p>Fagopay is a safe app that turns your phone into a mobile bank.
Its digital wallet that allows you to store, spend digital currency, pay utilities across merchants, and access other unique decentralized finance features.</p>

                        <a class="hero-btn two" href="{{ $heading['button_url'] ?? null }}">
                            Get Started
                        </a>
                    </div>
                </div>

                <!-- About Image -->
                <div class="col-lg-5 col-xl-6">
                    <div class="about-image mb-50">
                        <img src="{{ url('/') }}/frontend/png/20.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Area -->
@else

@endif
