<!DOCTYPE html>
<html  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @if($setting->icon_id)
        <link rel="apple-touch-icon" sizes="76x76" href="{{$setting->icon_id?$setting->favicon->address:''}}">
        <link rel="icon" type="image/png" href="{{$setting->icon_id?$setting->favicon->address:''}}">
    @endif
    <title>{{$title??env('app_env')}}</title>
    {!! SEOMeta::generate() !!}
    <!-- styles app css -->
    <link href="{{ url('/css/flowbite.min.css') }}" rel="stylesheet">
    <link href="{{ url('/css/fonts.css') }}" rel="stylesheet">
    <link href="{{ url('/css/all.min.css') }}" rel="stylesheet">
    <script src="{{url('/js/init-alpine.js')}}"></script>
    <link rel="stylesheet" href="{{url('css/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{url('/css/select2.min.css')}}" >
    <script src="{{url('/js/sweet-alert.min.js')}}"></script>

    @yield('style')

</head>
<body class="bg-white dark:bg-gray-900  font-vazir " dir="rtl">
@include('sweetalert::alert')

@include('layouts.navigation')

<main @if($alert) style="margin-top:101px;" @else style="margin-top:56px;" @endif>
    @yield('content')
</main>

<script src="{{url('/js/jquery.min.js')}}"></script>
<script src="{{url('/js/alpine.min.js')}}" ></script>
<script src="{{url('/js/flowbite.min.js')}}" ></script>
<script src="{{url('/js/dropzone.min.js')}}"></script>
<script src="{{url('/js/select2.min.js')}}"></script>
<script src="{{url('/plugin/ckeditor/ckeditor.js')}}"></script>
<script>
        $('#brand_id').select2({
        placeholder: '{{__('dashboard.brand')}}',
        ajax: {
        url: '{{route('search.brands')}}',
        dataType: 'json',
        delay: 220,
        processResults: function (data) {
        return {
        results: $.map(data, function (data) {
        return {
        text: data.title,
        id: data.id
    }
    })
    };
    },
        cache: true
    }
    });
        $('#category_id').select2({
        placeholder: '{{__('dashboard.category')}}',
        ajax: {
        url: '{{route('search.categories')}}',
        dataType: 'json',
        delay: 220,
        processResults: function (data) {
        return {
        results: $.map(data, function (data) {
        return {
        text: data.name,
        id: data.id
    }
    })
    };
    },
        cache: true
    }
    });
        $('#city_id').select2({
        placeholder: '{{__('dashboard.city')}}',
        ajax: {
        url: '{{route('search.cities')}}',
        dataType: 'json',
        delay: 220,
        processResults: function (data) {
        return {
        results: $.map(data, function (data) {
        return {
        text: data.name,
        id: data.id
    }
    })
    };
    },
        cache: true
    }
    });
        Dropzone.autoDiscover = false;
        var dropzone = new Dropzone('#photo_upload', {
            addRemoveLinks: true,
            dictDefaultMessage: "{{__('dashboard.uploadFile')}}",
            acceptedFiles: ".svg,.jpg,.png,.jpeg,.bmp,.gif",
            url: "{{ route('photo.upload') }}",
            sending: function(file, xhr, formData){
                formData.append("_token","{{csrf_token()}}")
            },
            success: function(file, response){
                alert("{{__('dashboard.uploaded')}}");
            }
        });
        Dropzone.autoDiscover = false;
        function selectPhoto(){
            $('#select_photo').empty();
            var id = $('input[name="photo_radio"]:checked').val();
            $.ajax({
                type: 'get',
                url: '/panel/photo/show/'+id,
                success: function(res){
                    $('#select_photo').append(`<img class="img-select shadow" src="${res}"  alt="" />`)
                }, error: function(){
                    alert('Error');
                }
            });
            $('#photo_id').val(id);
            $( "#multiSelectPhoto" ).addClass( 'hidden');
        }
        function selectImag(){
            $('#select_image').empty();
            var array = $.map($('input[name="photo_check"]:checked'), function(c){
                $.ajax({
                    type: 'get',
                    url: '/panel/photo/show/'+c.value,
                    success: function(res){
                        $('#select_image').append(`<img class="img-select shadow" src="${res}"  alt="" />`)
                    }, error: function(){
                        alert('Error');
                    }
                });
                return c.value;
            });
            $('#gallery').val(array);
            $( "#sampleSelect" ).addClass( 'hidden');
        }
        function loadImag(){
            window.location.reload();
        }
</script>
@yield('script')
</body>
</html>
