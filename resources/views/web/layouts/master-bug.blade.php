<!DOCTYPE html>
<html lang="fa">

<head>
    <meta charset="utf-8" />
    @if($setting->icon_id)
    <link rel="apple-touch-icon" sizes="76x76" href="{{$setting->favicon->url}}">
    <link rel="icon" type="image/png" href="{{$setting->favicon->url}}">
    @endif
    <!--
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!--     Fonts and icons     -->
    {!! SEO::generate(true) !!}
<!--     Fonts and icons     -->
    <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome/css/font-awesome.min.css')}}" />
    <!-- CSS Files -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/now-ui-kit.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/plugins/owl.carousel.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/plugins/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/main.css')}}" rel="stylesheet" />
    <link href="{{asset('frontend/css/front.css')}}" rel="stylesheet" />
    @yield('style')
    <script src="{{asset('js/sweet-alert.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/style-front.css') }}" type="text/css">

{{--    @include('layouts.chat')--}}
    <style>
        @media (max-width: 600px) {
            .w-sm-100{
                width:100% !important;
            }
        }
    </style>
</head>

<body class="position-relative">

@include('sweet::alert')

@yield('content')

<div class="fixed-bottom m-4 mr-auto rounded-circle" id="whatsapp" title="تماس با ما">
    <i class="fas fa-headset fa-3x text-light bg-info  p-2"></i>
</div>

<div class="container-fluid box-whatsapp d-none fixed-bottom rounded-lg" id="box_whatsapp">
    <div class="row rounded-lg">
        <div class="col-12 col-sm-8 col-md-4 col-lg-3 col-xl-2 ml-auto rounded-lg">
            <div class="">
                <table class="table table-hover table-striped table-light rounded shadow-lg">
                    <thead class="bg-danger text-light rounded">
                    <tr class="text-center">
                        <td colspan="2">
                            <span class="p-2">ارتباط با </span>
                            {{$setting->title}}
                            @if($setting->icon_id)
                                <img src="{{$setting->favicon->url}}" height="50" alt="">
                            @endif
                            <button type="button" class="close" id="box-close" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><a href="{{'tel:'.$setting->media->mobile}}" target="_blank"><i class="fas fa-phone text-dark fa-2x"></i></a></td>
                        <td>
                            <a href="{{'tel:'.$setting->media->mobile}}" target="_blank">
                                تماس با مدیر فروش
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="{{$setting->media->whatsapp}}" target="_blank"><i class="fab fa-whatsapp text-success fa-2x"></i></a></td>
                        <td>
                            <a href="{{$setting->media->whatsapp}}" target="_blank">
                                تماس با واتساپ
                            </a>
                        </td>
                    </tr>

                    <tr>
                        <td><a href="{{$setting->media->telegram}}" target="_blank"><i class="fab fa-telegram-plane text-info fa-2x"></i></a></td>
                        <td>
                            <a href="{{$setting->media->telegram}}" target="_blank">
                                کانال تلگرام
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="{{$setting->media->instagram}}" target="_blank"><i class="fab fa-instagram text-danger fa-2x"></i></a></td>
                        <td>
                            <a href="{{$setting->media->instagram}}" target="_blank">
                                پیج اینستاگرام
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="{{$setting->media->youtube}}" target="_blank"><i class="fab fa-youtube text-danger fa-2x"></i></a></td>
                        <td>
                            <a href="{{$setting->media->youtube}}" target="_blank">
                                کانال یوتیوب
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</body>
<!--   Core JS Files   -->
<script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="{{asset('assets/js/plugins/bootstrap-switch.js')}}"></script>
<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="{{asset('assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<!--  Plugin for the DatePicker, full documentation here: https://github.com/uxsolutions/bootstrap-datepicker -->
<script src="{{asset('assets/js/plugins/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<!-- Share Library etc -->
<script src="{{asset('assets/js/plugins/jquery.sharrre.js')}}" type="text/javascript"></script>
<!-- Control Center for Now Ui Kit: parallax effects, scripts for the example pages etc -->
<script src="{{asset('assets/js/now-ui-kit.js')}}" type="text/javascript"></script>
<!--  CountDown -->
<script src="{{asset('assets/js/plugins/countdown.min.js')}}" type="text/javascript"></script>
<!--  Plugin for Sliders -->
<script src="{{asset('assets/js/plugins/owl.carousel.min.js')}}" type="text/javascript"></script>
<!--  Jquery easing -->
<script src="{{asset('assets/js/plugins/jquery.easing.1.3.min.js')}}" type="text/javascript"></script>

<script src="{{asset('assets/js/plugins/jquery.ez-plus.js')}}" type="text/javascript"></script>
<!-- Main Js -->
<script src="{{asset('assets/js/main.js')}}" type="text/javascript"></script>
@yield('script')
<script>
    $(document).on('click','#whatsapp', function(){
        $('#box_whatsapp').addClass('d-block');
    });
    $(document).on('click','#box-close', function(){
        $('#box_whatsapp').removeClass('d-block');
        $('#box_whatsapp').addClass('d-none');
    });
</script>
</html>
