<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Stylesheets & Fonts -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    {{-- include full calendar cdn --}}
    @include('include.fullcalenderCDN')

  @yield('head')
  <link href="{{asset('css/main.css')}}" rel="stylesheet">
</head>
<body>
    @include('include.header')
    <div class="body-inner">
    <!-- Body Inner -->
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    @include('include.sessionMessage')
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</div>
<!-- Scroll top -->
<a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>
    <!--back-to-top end-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset('js/ajax.js?v=2')}}"></script>
@yield('script')
</html>
