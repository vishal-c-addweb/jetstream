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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
<!-- Scripts -->
<script src="{{ mix('js/app.js') }}" defer></script>
@livewireStyles
</head>

<body class="sidebar-menu-collapsed">
  <div class="se-pre-con"></div>
  <section>
    <!-- sidebar menu start -->
    @include('template.sidebar')
    <!-- //sidebar menu end -->
    
    <!-- header-starts -->
    <div class="header sticky-header" >

      @include('navigation-menu')

    </div>

