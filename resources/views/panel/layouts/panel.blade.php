<!DOCTYPE html>
<html  :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
@if($setting->favicon_id)
    <link rel="apple-touch-icon" sizes="76x76" href="{{$setting->favicon_id?$setting->favicon->address:''}}">
    <link rel="icon" type="image/png" href="{{$setting->favicon_id?$setting->favicon->address:''}}">
    @endif
    <title>{{$title??__('dashboard.dashboard')}}</title>
    <!-- styles app css -->
    <link href="{{ url('/css/app.css') }}" rel="stylesheet">
    <link href="{{ url('/css/fonts.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/leaflet.css')}}" >
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
    <script src="{{url('/js/sweet-alert.min.js')}}"></script>
    <script src="{{url('/js/init-alpine.js')}}"></script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    @yield('style')

</head>
<body class="font-vazir" dir="rtl">

@include('sweetalert::alert')

<div class="flex h-screen bg-gray-50 dark:bg-gray-900"  :class="{ 'overflow-hidden': isSideMenuOpen }">
    <!-- Desktop sidebar -->
@include('panel.layouts.panel_header')
<!-- Mobile sidebar -->
    <!-- Backdrop -->
    <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
    @include('panel.layouts.aside')
    <div class="flex flex-col flex-1 w-full">
        @include('panel.layouts.menu')
        <main class="h-full overflow-y-auto">
            @yield('content')
        </main>
    </div>
</div>

<script src="{{url('/js/alpine.min.js')}}" ></script>
<script src="{{url('/js/jquery.min.js')}}"></script>
<script>
    let darkButton=document.getElementById('dark_switch');
    darkButton.addEventListener('click',()=>{
        if (document.documentElement.classList.contains('dark')){
            localStorage.theme='light';
            document.documentElement.classList.remove('dark');
        }else {
            localStorage.theme='dark';
            document.documentElement.classList.add('dark');
        }
        location.reload();
    })
</script>
<script src="{{url('/js/leaflet.js')}}" ></script>
<script src="{{url('/js/flowbite.min.js')}}"></script>
<script src="{{asset('/js/select2.min.js')}}"></script>
<script>
    $("#image").change(function (e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-select').attr('src', e.target.result);
                $('#image-select').removeClass('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $(function() {
        var imagesPreview = function(input, placeToInsertImagePreview) {
            if (input.files) {
                var sliders=document.getElementById('slider');
                sliders.innerHTML="";
                var filesAmount = input.files.length;
                for (i = 0; i < filesAmount; i++) {
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        $($.parseHTML('<img alt="" class="img-fluid" style="width:100px;height: 100px;border-radius:7px;margin: 10px">')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
                    }
                    reader.readAsDataURL(input.files[i]);
                }
            }

        };
        $('#gallery').on('change', function() {
            imagesPreview(this, 'div#slider');
        });
    });
</script>
@yield('script')

</body>
</html>
