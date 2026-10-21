@php
$home_banner = DB::table('slider_banners')->where('active', 1)->first();
@endphp

<!-- ============================ Hero Banner  Start================================== -->
<div id="HomeSliderImage" class="image-cover half_banner" style="background:#0b2248 url({{asset(optional($home_banner)->image)}}) no-repeat;">
    <div class="container">
        <!-- Type -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                
            </div>
        </div>
    </div>
</div>
<!-- ============================ Hero Banner End ================================== -->

