
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
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{optional($company_info)->company_name}}</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset(optional($company_info)->logo) }}">

    <!-- CSS
	============================================ -->
    @include('user.pages.inc.style')
    @stack('frontend_style')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/dark_mode.css') }}">
</head>

<body class="rbt-header-sticky">

    @include('user.pages.inc.header')

    @yield('content')

    <div class="rbt-separator-mid">
        <div class="container">
            <hr class="rbt-separator m-0">
        </div>
    </div>
    <!-- Start Footer aera -->
    @include('user.pages.inc.footer')

    <!-- JS
============================================ -->
    @include('user.pages.inc.script')
    @stack('frontend_script')
</body>

</html>
