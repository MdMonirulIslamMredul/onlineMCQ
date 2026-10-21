<!-- Modernizer JS -->
<script src="{{ asset('/') }}frontend/assets/js/vendor/modernizr.min.js"></script>
<!-- jQuery JS -->

<script src="{{ asset('/') }}frontend/assets/js/vendor/jquery.js"></script>
<!-- Bootstrap JS -->
<script src="{{ asset('/') }}frontend/assets/js/vendor/bootstrap.min.js"></script>
<!-- sal.js -->
<script src="{{ asset('/') }}frontend/assets/js/vendor/sal.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/swiper.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/magnify.min.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/jquery-appear.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/odometer.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/backtotop.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/isotop.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/imageloaded.js"></script>
 <!-- Include slick JS -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script src="{{ asset('/') }}frontend/assets/js/vendor/wow.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/waypoint.min.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/easypie.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/text-type.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/jquery-one-page-nav.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/bootstrap-select.min.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/jquery-ui.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/magnify-popup.min.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/paralax-scroll.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/paralax.min.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/countdown.js"></script>
<script src="{{ asset('/') }}frontend/assets/js/vendor/plyr.js"></script>
<script src="{{ asset('js/toastify-js.js') }}"></script>


<!-- Main JS -->
<script src="{{ asset('/') }}frontend/assets/js/main.js"></script>
<script src="{{ asset('frontend/assets/js/dark_mode.js') }}"></script>
<!-- This page plugins -->
<!-- ============================================================== -->
{{-- <script src="{{ asset('js/jquery.lazyload.js') }}"></script> --}}
{{-- <script src="{{ asset('js/select2.min.js') }}"></script> --}}
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
{{-- <script src="{{ asset('js/custom.js') }}"></script> --}}


@if(session('notAllow'))
<script>
    swal({
        title: "{{ session('notAllow') }}",
        text: "",
        icon: "warning",
        button: "Ok",
    });

</script>
@endif

@if(session('userSuccess'))
<script>
    swal({
        title: "{{ session('userSuccess') }}",
        text: "",
        icon: "success",
        button: "Ok",
    });

</script>
@endif

@if(session('adminError'))
    <script>
      swal({
          title: "Error!",
          text: "{{ session('adminError') }}",
          icon: "error",
        });
    </script>
  @endif

<script>
    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7);
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>

<script>
    //
function unlock_category() {
    swal({
        title: "Warning",
        text: "⚠️ Please Unlock This Category or Login.",
        icon: "warning",
        button: "Ok",
    });

      $('html, body').animate({
        scrollTop: $('#unlockCategory').offset().top
      }, 500);
}


</script>
<script>

    $(document).ready(function(){
        $('.slick-slider').slick({
            autoplay:true,
            arrows:false,
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: false,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
            ]
        });
    });
    $(document).ready(function(){
        $('.slick-slider1').slick({
            autoplay:true,
            arrows:false,
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: false,
                        dots: true
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        dots: true
                    }
                }
            ]

        });
    });
</script>
