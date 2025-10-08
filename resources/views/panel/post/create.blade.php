@extends('panel.layouts.panel')


@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('posts.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.posts')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('posts.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" value="{{old('title')}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="slug">
                                {{__('dashboard.slug')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="slug" name="slug" type="text" value="{{old('slug')}}" placeholder="{{__('dashboard.enterSlug')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="url">
                                {{__('dashboard.url')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="url" name="url" type="url" value="{{old('url')}}" placeholder="{{__('dashboard.enterUrl')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" selected>{{__('dashboard.active')}}</option>
                                <option value="0">{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="payment_state" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.payment_state')}}</label>
                            <select name="payment_state" id="payment_state" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" selected>{{__('dashboard.so_rent')}}</option>
                                <option value="0">{{__('dashboard.advance_rent')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="const_price" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.const_price')}}</label>
                            <select name="const_price" id="const_price" class="form-select appearance-none dark:bg-gray-700 dark:text-gray-200 block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" selected>{{__('dashboard.active')}}</option>
                                <option value="0">{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                           <div class="flex justify-between">
                               <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="price">
                                   {{__('dashboard.price')}}
                               </label>
                               <span class="price font-bold mb-2 dark:text-gray-50"></span>
                           </div>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="price" name="price" type="text" value="{{old('price')}}" placeholder="{{__('dashboard.enterConstPrice')}}">
                        </div>
                        @include('panel.partials.photo',['photo'=>null])
                        <div class="w-full px-3  my-3">
                            <label for="description" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.description')}} </label>
                            <textarea name="description" class="form-textarea appearance-none block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{__('dashboard.enterDescription')}}" id="description" cols="30" rows="10">{{old('description')}}</textarea>
                        </div>
                        <div class="w-full px-3  my-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fa fa-save"></i>
                                {{__('dashboard.store')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{url('/js/numtopersian.min.js')}}"></script>
    <script src="{{url('/plugin/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('description',{
            customConfig: 'config.js',
            toolbar: 'simple',
            language: '{{Config::get('app.locale')}}',
            removePlugins: 'cloudservices, easyimage',
             filebrowserImageUploadUrl: "{{url('/')}}"+'/panel/upload-image?type=Images&_token=' + $('meta[name="csrf-token"]').attr('content'),
             filebrowserUploadMethod: 'form',
             filebrowserUploadUrl:"{{url('/')}}"+'/panel/upload-image?type=Images&_token=' + $('meta[name="csrf-token"]').attr('content'),
             filebrowserImage2BrowseUrl:"{{url('/')}}"+'/panel/upload-image?type=Images&_token=' + $('meta[name="csrf-token"]').attr('content'),
             filebrowserImageBrowseUrl: "{{url('/')}}"+'/panel/upload-image?type=Images&_token=' + $('meta[name="csrf-token"]').attr('content'),
             filebrowserBrowseUrl: "{{url('/')}}"+'/panel/upload-image?type=Files&_token=' + $('meta[name="csrf-token"]').attr('content'),
        });
        $("#title").keyup(function() {
            let title=$('#title').val();
            $.ajax({
                type: 'POST',
                url: "{{route('make.slug')}}",
                data: {
                    '_token':"{{csrf_token()}}",
                    'title':title
                },
                success: function(res){
                    $("#slug").val(res);
                }, error: function(){
                    console.log('error for slug make')
                }
            });

        });
        $('body').on('keyup', '#price', function() {
            let price=Num2persian($('#price').val())+" {{__('dashboard.toman')}} ";
            $('.price').html(price);
        });
    </script>

@endsection
