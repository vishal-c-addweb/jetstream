<!--
Author: W3layouts
Author URL: http://w3layouts.com
-->
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Project</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset ('css/style-starter.css') }}">

  <!-- google fonts -->
  <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>

</head>

<body class="sidebar-menu-collapsed">
  <div class="se-pre-con"></div>
  <section>
    <!-- sidebar menu start -->
    <div class="sidebar-menu sticky-sidebar-menu">

      <!-- logo start -->
      <div class="logo">
        <h1><a href="index.html">Menu</a></h1>
      </div>

      <!-- if logo is image enable this -->
        <!-- image logo --
        <div class="logo">
          <a href="index.html">
            <img src="image-path" alt="Your logo" title="Your logo" class="img-fluid" style="height:35px;" />
          </a>
        </div>
        <!--//image logo -->

      <div class="logo-icon text-center">
        <a href="/dashboard" title="logo" ><img src="{{ asset ('images/logo.png') }}" alt="logo-icon" style="margin-left:10px;"></a>
      </div>
      <!-- //logo end -->

      <div class="sidebar-menu-inner">

        <!-- sidebar nav start -->
        <ul class="nav nav-pills nav-stacked custom-nav">
          <li class="active"><a href="/dashboard"><i class="fa fa-tachometer"></i><span> Dashboard</span></a></li>
          <li><a href="/employee"><i class="fa fa-group"></i> <span>Employee</span></a></li>
          <li><a href="/department"><i class="fa fa-th-list"></i> <span>Department</span></a></li>
          <li><a href="/student"><i class="fa fa-graduation-cap"></i> <span>Student</span></a></li>
          <li><a href="/user"><i class="fa fa-user"></i> <span>User</span></a></li>
          <li><a href="/attendance"><i class="fa fa-clock-o"></i> <span>Attendance</span></a></li>
          <li><a href="/report"><i class="fa fa-newspaper-o"></i> <span>Report</span></a></li>
          <li><a href="/students"><i class="fa fa-line-chart"></i> <span>Livewire</span></a></li>
          
        </ul>
        <!-- //sidebar nav end -->
        <!-- toggle button start -->
        <a class="toggle-btn">
          <i class="fa fa-angle-double-left menu-collapsed__left"><span>Collapse Sidebar</span></i>
          <i class="fa fa-angle-double-right menu-collapsed__right"></i>
        </a>
        <!-- //toggle button end -->
      </div>

    </div>
    <!-- //sidebar menu end -->

    <!-- header-starts -->
    <div class="header sticky-header" >

      @include('navigation-menu')

    </div>

