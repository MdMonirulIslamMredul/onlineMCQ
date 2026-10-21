@php
$company_info = $company_info ?? DB::table('company_settings')->first();
$FooterfreeExams = DB::table('exams')->where('free_paid', 'free')->limit(5)->get();
@endphp

{{-- <footer class="dark-footer skin-dark-footer">
    <div>
        <div class="container">
            <div class="row">

                <div class="col-lg-3 col-md-4">
                    <div class="footer-widget">
                        <img src="{{ asset(optional($company_info)->logo) }}" class="img-footer" alt="">
                        <div class="footer-add">
                            <p>{{ optional($company_info)->address }}</p>
                            <p>{{ optional($company_info)->phone_1 }}, {{ optional($company_info)->phone_2 }}</p>
                            <p>{{ optional($company_info)->email }}</p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Navigations</h4>
                        <ul class="footer-menu">
                            <li><a href="{{route('user.about_us')}}">About Us</a></li>
                            <li><a href="{{route('user.contact_us')}}">Contact</a></li>
                            <li><a href="{{route('user.mission_and_vission')}}">Mission & Vission</a></li>
                            <li><a href="{{route('user.certificate_number')}}">TIN Certificate Number</a></li>
                            <li><a href="{{route('user.privacy_and_policy')}}">Privacy and Policy</a></li>
                            <li><a href="{{route('user.return_and_refund_policy')}}">Refund/Return policy</a></li>
                            <li><a href="{{route('user.trams_and_conditions')}}">Terms and Conditions</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="footer-widget">
                        <h4 class="widget-title">Free Exams</h4>
                        <ul class="footer-menu">
                            @foreach($FooterfreeExams as $exam)
                            @php
                                $Eurl = str_replace(" ","-", $exam->exam_name);
                                $key = rand(10000, 199999);
                            @endphp
                            <li><a href="{{url('/start-mcq-exam/'.$exam->id.'/'.$Eurl.'/'.$key)}}">{{$exam->exam_name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12">
                    <div class="footer-widget">
                        <h4 class="widget-title">Download Apps</h4>
                        <a href="https://play.google.com/store/apps/details?id=apps.englishexplorerbd.com" class="other-store-link">
                            <div class="other-store-app">
                                <div class="os-app-icon">
                                    <i class="lni-playstore theme-cl"></i>
                                </div>
                                <div class="os-app-caps">
                                    Google Play
                                    <span>Get It Now</span>
                                </div>
                            </div>
                        </a>
                        <a href="https://apps.apple.com/gb/app/english-explorer-bd/id1604725649" class="other-store-link">
                            <div class="other-store-app">
                                <div class="os-app-icon">
                                    <i class="lni-apple theme-cl"></i>
                                </div>
                                <div class="os-app-caps">
                                    App Store
                                    <span>Now it Available</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6">
                    <p class="mb-0">© 2021 Designd & Developed By <a target="_blank" href="http://faraitfusion.com/">FARA IT Limited</a>.</p>
                </div>

                <div class="col-lg-3 col-md-3 text-right">
                 <img src="{{asset('./public/images/payment_banner.png') }}" height="30" class="mw-100 h-auto" style="max-height: 30px">
                </div>

                <div class="col-lg-3 col-md-3 text-right">
                    <ul class="footer-bottom-social">
                        <li><a href="{{ optional($company_info)->facebook }}"><i class="ti-facebook"></i></a></li>
                        <li><a href="{{ optional($company_info)->youtube }}"><i class="fa fa-youtube-play"></i></a></li>
                        <li><a href="{{ optional($company_info)->twitter }}"><i class="ti-twitter"></i></a></li>
                        <li><a href="{{ optional($company_info)->instagram }}"><i class="ti-instagram"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</footer> --}}
<!-- ============================ Footer End ================================== -->

<!-- Log In Modal -->
{{-- <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="registermodal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered login-pop-form" role="document">
        <div class="modal-content" id="registermodal">
            <span class="mod-close" data-dismiss="modal" aria-hidden="true"><i class="ti-close"></i></span>
            <div class="modal-body">
                <h4 class="modal-header-title">Sign In</h4>
                <div class="login-form">
                    <form action="{{route('user.login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Email or Phone</label>
                            <input type="text" name="email_or_phone" required class="form-control" placeholder="Email Or Phone">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required class="form-control" placeholder="*******">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-md full-width pop-login">Login</button>
                        </div>
                    </form>
                </div>

                <div class="social-login mb-3">
                    <ul>
                        <li>
                            <input id="reg" class="checkbox-custom" name="reg" type="checkbox">
                            <label for="reg" class="checkbox-custom-label">Save Password</label>
                        </li>
                        <li class="right"><a href="{{route('user.password.reset')}}" class="theme-cl">Forget Password?</a></li>
                    </ul>
                </div>
                <div class="text-center">
                    <p class="mt-2">Haven't Any Account? <a href="{{route('user.register.page')}}" class="link">Click here</a></p>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<!-- End Modal -->

<a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>


</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('frontend11/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/select2.min.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/slick.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/counterup.min.js') }}"></script>
<script src="{{ asset('frontend11/assets/js/custom.js') }}"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<script src="{{ asset('js/toastify-js.js') }}"></script>
<script src="{{ asset('js/jquery.lazyload.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('frontend/assets/js/dark_mode.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>



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


    // Begin:: Quantity Plus Minus
    function Qunatity_Plus() {
        var current_quantity = $('#books_quantity').val();
        var now = parseInt(current_quantity) + parseInt(1);
        $('#books_quantity').val(now);
    }

    function Qunatity_Minus() {
        var current_quantity = $('#books_quantity').val();
        if(current_quantity == 1) {
            Toastify({
             text: 'Sorry, minimum quantity is 1',
             backgroundColor: "linear-gradient(to right, #F50057, #F9A826)",
             className: "error",
           }).showToast();
        }
        else {
            var now = parseInt(current_quantity) - parseInt(1);
            $('#books_quantity').val(now);
        }

    }
    // End:: Quantity Plus Minus


</script>
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200, // Set editor height
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>



</body>
</html>
