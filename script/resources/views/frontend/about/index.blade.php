@extends('layouts.frontend.app')

@section('content')

    <!-- About Us Area -->
    <div class="single-about-us-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="about-2-img">
                        <img src="{{ asset($about->image) }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About Us Area -->

      
      <section class="section plan-section padding-bottom ">
         <div class=" container col-md-12">
             
             <section class="w-100 float-left sloution-box-con overflow">
         <div class="col-md-12">
            <div class="sloution-box-content text-md-left ">
               <div class="row">
                  <div class="col-lg-7 col-md-6">
                     <div class="sloution-box-right-content wow slideInRight">
                       
                        <h3>The <b>Company</b></h3>
                        <p class="col-lg-11 pl-0">Fagopay is a financial technology company headquartered in Katsina, Nigeria that will be providing quasi-banking services for individuals and digital payment solutions for businesses and organisations
                           in Nigeria and the rest of Africa. <br><br>Our goal is to help merchants give
                           their customers a seamless payments experience, while providing
                           digital banking services to the unbanked and underbanked.<br>
                           Fagopay builds infrastructure that enables physical stores, mobile
                           merchants, and other businesses and organisations to accept payments from the different channels their clients may need to use all
                           in one place</p>
                     </div>

                     <div class="sloution-box-right-content wow slideInRight">
                       
                        <h3>Our <b>Vision</b></h3>
                        <p class="col-lg-11 pl-0">To enable businesses and organisations
                           across Africa to become more profitable, productive, and able to
                            accommodate scale.</p>
                             <h3>Our <b>Mission</b></h3>
                        <p class="col-lg-11 pl-0">Developing quality and innovative features across our digital
                           payment softwares and APIs to drive business growth.
                           Providing Individuals with a digital platform to make and
                            manage payments among other financial services.</p>
                     </div>
                  </div>
                  <div class="col-lg-5 col-md-6">
                     <div class="sloution-box-lft-content wow slideInLeft">
                        <figure class="mb-0">
                           <img src="{{ url('/') }}/frontend/png/sloution-box-lft-img.png" alt="sloution-box-lft-img">
                        </figure>
                       
                     </div>
                  </div>
                 
               </div>
            </div>
         </div>
      </section>
      
      <br>
      <br>
            <div class="row">
            <div class=" col-md-8 px-4 py-5">
            <h2 class="text-center">Choose our seamless payments experience.</h2>
            <div class="d-flex justify-content-center">
               <div class="plan-full">
                  <div class="plan-heading d-flex">
                     <div class="plan-single"></div>
                     <div class="plan-single"><h3>Others</h3></div>
                     <div class="plan-single"><img src="{{ url('/') }}/frontend/png/logc-02.png" width="110"></div>
                  </div>
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Free Transfer</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>For where?</p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">Free Forever</span></p>
                     </div>
                  </div>
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Crypto Deposit</strong></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="emoji-icon"><img src="https://www.dafribank.com/public/assets/assets/images/emoji/smirk-face-emoji.png" alt="roll eye"></span></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">First to do it</span></p>
                     </div>
                  </div>
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Debit Card</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>$7.6 V.A.T</p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">Free</span></p>
                     </div>
                  </div>
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Merchant API</strong></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="emoji-icon"><img src="https://www.dafribank.com/public/assets/assets/images/emoji/unamused-face-emoji.png" alt="roll eye"></span></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">We are the best</span></p>
                     </div>
                  </div>
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Crypto Currency</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>Always fudding <span class="emoji-icon"><img src="https://www.dafribank.com/public/assets/assets/images/emoji/eye-roll-emoji.png" alt="roll eye"></span></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">We buy the dip</span></p>
                     </div>
                  </div>
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Forex</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>Hates traders, account frozen</p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">Traders best friend</span></p>
                     </div>
                  </div>
                  
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Bill Payment</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>Standard fee</p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">Never</span></p>
                     </div>
                  </div>
                  
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Account Maintenance Fee</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>Yes</p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">Are you serious?</span></p>
                     </div>
                  </div>
                  
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Crypto Withdrawal</strong></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="emoji-icon"><img src="https://www.dafribank.com/public/assets/assets/images/emoji/face-with-head-bandage-emoji.png" alt="roll eye"></span></p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">Anytime is a tea time</span></p>
                     </div>
                  </div>
                  
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Cross Border Payment</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>5 days</p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">10 minutes</span></p>
                     </div>
                  </div>
                  
                  <div class="plan-single-row">
                     <div class="plan-single">
                        <p><strong>Annual Interest</strong></p>
                     </div>
                     <div class="plan-single">
                        <p>3.6% </p>
                     </div>
                     <div class="plan-single">
                        <p><span class="check-circle"><i class="fas fa-check"></i></span> <span class="check-text">80%</span></p>
                     </div>
                  </div>
                  
               </div>
            </div> </div>
         
      
      
         <div class="col-md-4 px-4">
            
              <div class="timeline">
                
                <h3>Roadmap</h3>
                <label>Our Journey to success</label>
                
                
                <div class="box">
                  
                  <div class="container">
                    
                    <div class="lines">
                      <div class="dot"></div>
                      <div class="line"></div>
                      <div class="dot"></div>
                      <div class="line"></div>
                      <div class="dot"></div>
                      <div class="line"></div>
                    </div>
                    
                    <div class="cards">
                      <div class="cardd">
                        
                        <h4>2022</h4>
                        <p>Believing Is The Absence<br> Of Doubt</p>
                      </div>
                      <div class="cardd">
                        <h4>2021</h4>
                        <p>Start With A Baseline</p>
                      </div>
                      <div class="cardd">
                        <h4>2020</h4>
                        <p>Break Through Self Doubt<br> And Fear</p>
                      </div>
                    </div>
                    
                  </div>
                  
                </div> </div>
             </div> 
            
            
            </div> </div>
      </section>
      
      <section class="w-100 float-left service-con padding-bottom">
         <div class="container">
            <div class="service-inner-con position-relative dotted-img">
               <div class="genric-heading text-center">
                  <h2 class="position-relative">Meet Our Team</h2>
                  <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incid <br>
                     idunt ut labore et dolore magna aliqua.</p>
               </div>
                  <div class="team-box-con wow fadeInUp  text-center">
                     <div class="row">
                        <div class="col-lg-4 col-md-4">
                           <div class="team-box-item">
                                 <figure>
                                    <img src="{{ url('/') }}/frontend/png/yusuf.png" alt="team-img" class="img-fluido">
                                 </figure>
                              <h4>Yusuf Daddy Salisu</h4>
                              <p>President - CEO</p>
                              <div class="team-social-icon">
                                 <ul class="mb-0 list-unstyled">
                                    <li class="d-inline-block"><a href="https://www.instagram.com/"><span class="fab fa-instagram d-flex align-items-center justify-content-center"></span></a></li>
                                    <li class="d-inline-block"><a href="https://twitter.com/"><span class="fab fa-twitter d-flex align-items-center justify-content-center"></span></a></li>
                                    <li class="d-inline-block"><a href="https://www.linkedin.com/"><span class="fab fa-linkedin-in d-flex align-items-center justify-content-center"></span></a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-4 col-md-4">
                           <div class="team-box-item">
                                 <figure>
                                    <img src="{{ url('/') }}/frontend/png/obasa.png" alt="team-img" class="img-fluido">
                                 </figure>
                              <h4>Abubakar Nasir</h4>
                              <p>COO</p>
                              <div class="team-social-icon">
                                 <ul class="mb-0 list-unstyled">
                                    <li class="d-inline-block"><a href="https://www.instagram.com/"><span class="fab fa-instagram d-flex align-items-center justify-content-center"></span></a></li>
                                    <li class="d-inline-block"><a href="https://twitter.com/"><span class="fab fa-twitter d-flex align-items-center justify-content-center"></span></a></li>
                                    <li class="d-inline-block"><a href="https://www.linkedin.com/"><span class="fab fa-linkedin-in d-flex align-items-center justify-content-center"></span></a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                       

                        <div class="col-lg-4 col-md-4">
                           <div class="team-box-item mb-0">
                                 <figure>
                                    <img src="{{ url('/') }}/frontend/png/jafar.png" alt="team-img" class="img-fluido">
                                 </figure>
                              <h4>Jafar Alabi</h4>
                              <p>Head of Products</p>
                              <div class="team-social-icon">
                                 <ul class="mb-0 list-unstyled">
                                    <li class="d-inline-block"><a href="https://www.instagram.com/"><span class="fab fa-instagram d-flex align-items-center justify-content-center"></span></a></li>
                                    <li class="d-inline-block"><a href="https://twitter.com/"><span class="fab fa-twitter d-flex align-items-center justify-content-center"></span></a></li>
                                    <li class="d-inline-block"><a href="https://www.linkedin.com/"><span class="fab fa-linkedin-in d-flex align-items-center justify-content-center"></span></a></li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
            </div>
            
         </div>
      </section>

    @include('frontend.home.review')
@endsection
