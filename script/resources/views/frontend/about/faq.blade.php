@extends('layouts.frontend.app')

@section('content')


<link rel="stylesheet" href="{{url('/')}}/frontend/nfc/css/66dfdc84a65c3efb5c5e61c276308a4a.css" media="all" data-minify="1" />

<div class="header-and-banner-con w-100 generic-banner-con">
<section class="banner-main-con">
               <div class="container">
                  <!--banner-start-->
                  <div class="banner-con text-center">
                   <h1 class="page-title" style="color:#280721;">{{__('Frequesntly Asked Questions')}}</h1>
                  </div>
                  <!--banner-end-->
               </div>
            </section>
         </div>
      </div> </div>


    		<div data-elementor-id="245" class="elementor elementor-245">
									<section class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default elementor-section-height-default" data-elementor-id="245" data-element_type="section" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="faq-area ">
        <div class="container">


            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-md-9 col-lg-6">
                    <div class="faq-content mb-50">
                        <div class="accordion faq-accordian " id="faqaccordian">
                            @forelse($data['faqs'] ?? [] as $faq)
                            <!-- Single FAQ -->
                            <div class="card border-0">
                                <div class="card-header tab-heading-card" id="heading{{ $loop->index }}">
                                    <button class="btn tab-heading" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $loop->index }}" aria-expanded="{{ $loop->first ? "true": "false" }}"
                                            aria-controls="collapse{{ $loop->index }}">{{ $faq->question }}</button>
                                </div>
                                <div @class(['collapse', 'show' => $loop->first]) id="collapse{{ $loop->index }}" aria-labelledby="heading{{ $loop->index }}"
                                     data-bs-parent="#faqaccordian">
                                    <div class="card-body">
                                        <p>{{ $faq->answer }}</p>
                                    </div>
                                </div>
                            </div>
                            @empty

                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
		</section>
		
							</div>
							
					
<script type='text/javascript' id='elementor-frontend-js-before'>
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Extra","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Extra","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}}},"version":"3.6.6","is_static":false,"experimentalFeatures":{"e_dom_optimization":true,"e_optimized_assets_loading":true,"a11y_improvements":true,"e_import_export":true,"e_hidden_wordpress_widgets":true,"landing-pages":true,"elements-color-picker":true,"favorite-widgets":true,"admin-top-bar":true},"urls":{"assets":""},"settings":{"page":[],"editorPreferences":[]},"kit":{"active_breakpoints":["viewport_mobile","viewport_tablet"],"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description"},"post":{"id":245,"title":"FAQ%E2%80%99s%20%E2%80%93%20ProgriSaaS","excerpt":"","featuredImage":false}};
</script>
<script src="https://code.jquery.com/jquery-2.2.4.min.js" type="text/javascript"></script>
<script src="https://progrisaas.archiwp.com/wp-content/cache/min/1/4b038917e8aa369f0e7bd341f19fe324.js" data-minify="1"></script>
   
   
   
   
    @include('frontend.home.review')
@endsection
