<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if($setting->favicon_id)
        <link rel="apple-touch-icon" sizes="76x76" href="{{$setting->favicon?$setting->favicon->address:''}}">
        <link rel="icon" type="image/png" href="{{$setting->favicon?$setting->favicon->address:''}}">
    @endif
    <title>{{$title??env('app_env')}}</title>
    {{--    {!! SEOMeta::generate() !!}--}}
    <!-- styles app css -->
    <link href="{{ url('/css/flowbite.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ url('/css/all.min.css') }}" rel="stylesheet">
    <script src="{{url('/js/init-alpine.js')}}"></script>
    <script src="{{url('/js/sweet-alert.min.js')}}"></script>
    @yield('style')

</head>
<body class="font-vazir" dir="ltr">
@include('sweetalert::alert')

@yield('content')


<script src="{{url('/js/alpine.min.js')}}" ></script>
<script src="{{url('/js/jquery.min.js')}}"></script>
<script src="{{url('/js/flowbite.min.js')}}" ></script>
@yield('script')
</body>
</html>
