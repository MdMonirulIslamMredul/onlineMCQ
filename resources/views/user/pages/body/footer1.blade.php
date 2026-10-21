

@php
$company_info = $company_info ?? DB::table('company_settings')->first();
$FooterfreeExams = DB::table('exams')->where('free_paid', 'free')->limit(5)->get();
@endphp
<footer>

        {{-- <div class="container">
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


            </div>
        </div> --}}


    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-md-6">
                    <p class="mb-0">{{ optional($company_info)->footer_credit }}</p>
                </div>

                {{-- <div class="col-lg-3 col-md-3 text-right">
                 <img src="{{asset('./public/images/payment_banner.png') }}" height="30" class="mw-100 h-auto" style="max-height: 30px">
                </div> --}}

                <div class="col-lg-6 col-md-3 text-right">
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
</footer>
