@php
    $admin_id = session()->get('admin_id');
    $Admin_Q = DB::table('admins')->where(['id'=>$admin_id])->first();
    $company_info = DB::table('company_settings')->first();
    
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard 
    @if(!empty(optional($company_info)->company_name))
       {{ optional($company_info)->company_name }}
    @endif
  </title>

  <link rel="stylesheet" href="{{ asset('backend/datatable/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/datatable/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/datatable/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/app.min.css') }}">
  <!-- <link rel="stylesheet" href="{{ asset('backend/assets/bundles/datatables/datatables.min.css') }}"> -->
  <!-- <link rel="stylesheet" href="{{ asset('backend/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}"> -->
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('backend/assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('backend/assets/css/custom.css') }}">
  @if(!empty(optional($company_info)->logo))
       <link rel='shortcut icon' type='image/x-icon' href="{{ asset(optional($company_info)->logo) }}" />
  @else
      <link rel='shortcut icon' type='image/x-icon' href="" />
  @endif
  <!-- BEGIN: Custom Toster-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- END: Custom Toster-->

  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <style>
    .cke_notification_warning,
    .cke_notification[data-type="warning"],
    .cke_notifications_area {
        display: none !important;
        visibility: hidden !important;
    }
  </style>
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      
        <!-- BEGIN: Header-->
            @include('cms.body.header')
        <!-- END: Header-->

       <!-- BEGIN: Main Menu-->
            @include('cms.body.left_sidebar')
       <!-- END: Main Menu-->


      <!-- Main Content -->
      <div class="main-content">
            @yield('admin_content')
      </div>

      <!-- BEGIN: Footer-->
           @include('cms.body.footer')
      <!-- End: Footer-->