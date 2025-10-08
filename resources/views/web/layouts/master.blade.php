<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    @if($setting->icon_id)
    <link rel="apple-touch-icon" sizes="76x76" href="{{$setting->favicon->url}}">
    <link rel="icon" type="image/png" href="{{$setting->favicon->url}}">
    @endif
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title??'' }}</title>
    {!! SEO::generate(true) !!}
    <!--     Fonts and icons     -->
    <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome/css/font-awesome.min.css')}}" />
    <!-- CSS Files -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/now-ui-kit.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/plugins/owl.carousel.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/plugins/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/main.css')}}" rel="stylesheet" />
    <link href="{{asset('/css/select2.min.css')}}" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('css/style-front.css') }}" type="text/css">

    <script src="{{asset('js/sweet-alert.min.js')}}"></script>

    @yield('style')
    <style>
        .default{
            margin:0 !important;
        }
    </style>

</head>
<body class="index-page sidebar-collapse default" id="apps">

    @include('sweet::alert')

    @if(asset($coupon)||asset($alert))
        <div class="alert-coupon">
            @if(isset($alert))
                @include('layouts.notification')
            @endif
            @if(isset($coupon))
                @include('layouts.coupon')
            @endif
        </div>
    @endif

    @include('layouts.header_response')

    <div class="wrapper default">

        @include('layouts.header')

               @yield('content')

        @include('layouts.footer')

    </div>

   <div class="fixed-bottom m-4 mr-auto rounded-circle" id="whatsapp" style="cursor: pointer" title="تماس با ما">
       <i class="fas fa-headset fa-3x text-light bg-info  p-2"></i>
       ارتباط با ما
   </div>
   <div class="container-fluid box-whatsapp d-none fixed-bottom rounded-lg" id="box_whatsapp">
       <div class="row rounded-lg">
           <div class="col-12 col-sm-8 col-md-4 col-lg-3 col-xl-2 ml-auto rounded-lg">
               <div class="">
                   <table class="table table-hover table-striped table-light rounded shadow-lg">
                       <thead class="bg-info text-light rounded">
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





    <!-- Scripts -->
    <script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
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
    <script src="{{asset('/js/select2.min.js')}}" type="text/javascript"></script>

{{--    <script src="{{asset('/js/app.js')}}" type="text/javascript"></script>--}}
{{--    <script src="{{asset('/js/device-uuid.js')}}" type="text/javascript"></script>--}}


    <script>
        function showDropdown(){
            $('.dropdown-menu').addClass('show');
            $('.dropdown').addClass('show');
        }
        function removeShow(){
            $('.dropdown-menu').removeClass('show');
            $('.dropdown').removeClass('show');
        }
    </script>
    <script type="text/javascript">
        var _token = $('input[name="_token"]').val();

        $('#searchin').keyup(function (){
            var search = $("#searchin").val();
            $('#container2').css("display","block");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{q:search},
                url:"{{ route('product.search') }}",
                method:"POST",
                dataType:"json",
                success:function(data) {
                    var i;
                    $('#list').html(null);
                    for (i=0; i < data.length ;i++){
                        if (i == (data.length - 1)){
                            $('#list').append("<hr style='padding:0.7px!important;margin:0!important;background-color:#ababab;'>");
                        }
                        $('#list').append("<li style='padding:8px!important;'><a href='"+data[i].href+"'><i class='fa fa-search p-2'></i><span class='text-info'>"+ data[i].title +"</span>"+ data[i].type + data[i].title_en +"</a></li>");
                    }
                    if (search.length==0){
                        $('#container2').css("display","none");
                    }
                }
            });
        });

        $('#search').keyup(function (){
            var searches = $("#search").val();
            $('#containers').css("display","block");
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{q:searches},
                url:"{{ route('product.search') }}",
                method:"POST",
                dataType:"json",
                success:function(data) {
                    var j;
                    $('#lists').html(null);
                    for (j=0; j < data.length ;j++){
                        $('#lists').append("<li style='padding:4px!important;' ><a href='"+data[j].href+"' style='font-size:12px!important'><i class='fa fa-search p-2'></i><span class='text-info'>"+ data[j].title +"</span>"+ data[j].type + data[j].title_en +"</a></li>");
                    }
                    if (searches.length==0){
                        $('#containers').css("display","none");
                    }
                }
            });
        });

    </script>
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
</body>
</html>

