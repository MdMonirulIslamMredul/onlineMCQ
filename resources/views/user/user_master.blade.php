@php
$company_info = DB::table('company_settings')->first();
$userID = Cookie::get('user_id');
$userName = Cookie::get('user_name');
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Instant Theme Detection Script (Prevents White Flash) -->
    <script>
        (function() {
            var theme = localStorage.getItem('app_theme');
            if (theme === 'dark' || (!theme && window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark-theme');
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark-theme');
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    <meta charset="utf-8">
    <meta name="author" content="www.frebsite.nl">
    <meta name="description" content="{{ optional($company_info)->company_name }}">
    <meta name="keywords" content="{{ optional($company_info)->company_name }}">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>{{ optional($company_info)->company_name }}</title>
    <link rel="icon" href="{{ asset(optional($company_info)->logo) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset(optional($company_info)->logo) }}" type="image/x-icon">

    <!-- Custom CSS -->
    <link href="{{ asset('frontend11/assets/css/styles.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">
    <script src="{{ asset('js/fontawesome.js') }}" crossorigin="anonymous"></script>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<!-- Summernote CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">


    <!-- Custom Color Option -->
    <link href="{{ asset('frontend11/assets/css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/css/student_modern.css') }}" rel="stylesheet">

    <style>
       @media only screen and (max-width: 700px) {
         .PaulTitle {
             padding-left: 10px;
         }
         #clockdiv{
            font-family: sans-serif;
            color: #fff;
            display: inline-block;
            font-weight: 100;
            text-align: center;
            font-size: 10px;
            /* position: fixed; */
            }

            #clockdiv > div{
            padding: 4px;
            border-radius: 3px;
            background: #00BF96;
            display: inline-block;
            }

            #clockdiv div > span{
            padding: 2px 6px;
            border-radius: 3px;
            background: #00816A;
            display: inline-block;
            }

            .smalltext{
            font-size: 10px;
            }

            .sticky {
                position: -webkit-sticky !important;
                position: sticky;
                top: 20px;
                overflow:hidden;
            }

            .height27 {
                height: 25px !important;
            }
            #noticeMoblie {
                font-size: 13px;
                text-align: right;
            }
            #marQueee {
                font-size: 13px;
                margin-top: 1px;
            }

            #marqueeeFather {
                padding-right: 0px;
                padding-left: 0px;
            }

            .navigation-portrait .nav-menu>li>a {
                color: #000;

            }

            .input-group-field{
                width: 80px;
                padding-top: 3px;
                padding-bottom: 3px;

            }

      }

      @media only screen and (min-width: 701px) {
         .half_banner {
            /* padding: 180px 0 !important; */
            width: 100%;
            height: 400px;
         }

         #clockdiv{
            font-family: sans-serif;
            color: #fff;
            display: inline-block;
            font-weight: 100;
            text-align: center;
            font-size: 20px;
            /* position: fixed; */
            }

            #clockdiv > div{
            padding: 8px;
            border-radius: 3px;
            background: #00BF96;
            display: inline-block;
            }

            #clockdiv div > span{
            padding: 2px 10px;
            border-radius: 3px;
            background: #00816A;
            display: inline-block;
            }

            .smalltext{
            padding-top: 2px;
            font-size: 16px;
            }

            .sticky {
                position: -webkit-sticky !important;
                position: sticky;
                top: 20px;
                overflow:hidden;
            }

            .height27 {
                height: 27px !important;
            }


      }

      .individualExam {
          margin-top: 5px;
          padding: 10px;
          border: 1px solid #CDCDCD;
          border-radius: 10px;
          width: 95%;

      }
      .individualExam:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

      }
      .indviExamA:hover {
          color: #DA0B4E;
      }

      #timerCount {
          position: fixed;
          background-color: #FFFFFF;
          padding: 5px;
          border-radius: 15px;
      }

      .mcqRightAns {
          font-size: 20px;
      }





        .plus-minus-input {
          -webkit-align-items: center;
              -ms-flex-align: center;
                  align-items: center;
                  width: 338px;

        }

        .plus-minus-input .input-group-field {
          text-align: center;
          margin-left: 0.5rem;
          margin-right: 0.5rem;
          padding: 1rem;
          padding-left: 0px;
          padding-right: 0px;
        }

        .plus-minus-input .input-group-field::-webkit-inner-spin-button,
        .plus-minus-input .input-group-field ::-webkit-outer-spin-button {
          -webkit-appearance: none;
                  appearance: none;
        }

        .plus-minus-input .input-group-button .circle {
          border-radius: 50%;
          padding: 0.25em 0.8em;
        }

        .input-group {
            border: none;
        }





    </style>

    <link href="{{ asset('frontend/assets/css/dark_mode.css') }}" rel="stylesheet">
</head>

<body class="red-skin">

    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <!--<div id="preloader">-->
    <!--    <div class="preloader"><span></span><span></span></div>-->
    <!--</div>-->


    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">




        <!--header start-->
        @include('user.pages.body.header')
        <!--header end-->

        <!--Body end-->
        @yield('user_content')
        <!--Body end-->


        <!-- footer start -->
        @include('user.pages.body.footer')
        <!-- footer End -->
        @include('user.pages.body.footer1')
