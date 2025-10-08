@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('settings.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.settings')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('settings.update',$panel->id)}}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$panel->id}}">
                    <div class="flex flex-wrap mx-3 my-2">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="title" name="title" type="text" value="{{$panel->title}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="url">
                                {{__('dashboard.url')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="url" name="url" type="text" value="{{$panel->url}}" placeholder="{{__('dashboard.enterUrl')}}">
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="product_text">
                                {{__('front.product_text')}}
                            </label>
                            <textarea class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="5" id="product_text" name="product_text"  placeholder="{{__('front.enterProductText')}}">{!!$panel->product_text!!}</textarea>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">@lang('dashboard.favicon')</label>
                            <input type="file" name="favicon" id="favicon" class="ppearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" >
                            <img id="favicon_id" src="{{$panel->favicon_id?$panel->favicon->address:null}}" alt="" width="100" height="100" class="rounded object-cover" >
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">@lang('dashboard.logo')</label>
                            <input type="file" name="logo" id="logo" class="ppearance-none block w-full bg-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" >
                            <img alt="" id="logo_id" src="{{$panel->logo_id?$panel->logo->address:null}}" width="100" height="100" class="rounded object-cover">
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="about">
                                {{__('dashboard.about')}}
                            </label>
                            <textarea class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="5" id="about" name="about"  placeholder="{{__('alert.enterAbout')}}">{{$panel->about}}</textarea>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="address">
                                {{__('dashboard.address')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="address" name="address" type="text" value="{{$panel->address}}" placeholder="{{__('dashboard.enterAddress')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <div class="flex justify-between">
                                <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="free_post">
                                    {{__('dashboard.free_post')}}
                                </label>
                                <span class="free_post font-bold mb-2 dark:text-gray-50"></span>
                            </div>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="free_post" name="free_post" type="text" value="{{$panel->free_post}}" placeholder="{{__('dashboard.enterFreePost')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="tel">
                                {{__('dashboard.tel')}}
                            </label>
                            <input class="appearance-none block w-full  bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="tel" name="tel" type="tel" value="{{$panel->tel}}" placeholder="{{__('dashboard.enterTel')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-left text-gray-700 dark:text-gray-50 font-bold mb-2" for="email">
                                {{__('dashboard.email')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="email" name="email" type="email" value="{{$panel->email}}" placeholder="{{__('dashboard.enterEmail')}}">
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50  font-bold mb-2" for="copy_right">
                                {{__('dashboard.copy_right')}}
                            </label>
                            <textarea class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="5" id="copy_right" name="copy_right"  placeholder="{{__('dashboard.enterCopyRight')}}">{{$panel->copy_right}}</textarea>
                        </div>
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50  font-bold mb-2" for="text_chat">
                                {{__('dashboard.text_chat')}}
                            </label>
                            <textarea class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="5" id="text_chat" name="text_chat"  placeholder="{{__('dashboard.text_chat')}}">{{$panel->text_chat}}</textarea>
                        </div>
                        @include('panel.partials.media_edit',['object'=>$panel??null])
                        @include('panel.partials.meta_edit',['object'=>$panel])
                        <div class="w-full px-3 my-3">
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
    <script src="{{asset('plugin/ckeditor/ckeditor.js')}}"></script>
    <script>
        $('body').on('keyup', '#free_post', function() {
            let price=Num2persian($(this).val())+" {{__('dashboard.toman')}} ";
            $('.free_post').html(price);
        });
        $("#favicon").change(function (e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#favicon_id').attr('src', e.target.result);
                    $('#favicon_id').removeClass('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        $("#logo").change(function (e) {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#logo_id').attr('src', e.target.result);
                    $('#logo_id').removeClass('hidden');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        CKEDITOR.replace('product_text',{
            customConfig: 'config.js',
            toolbar: 'simple',
            language: '{{Config::get('app.locale')}}',
            removePlugins: 'cloudservices, easyimage',
            filebrowserImageUploadUrl: '/panel/upload-image?type=Images',
            filebrowserUploadMethod: 'form',
            filebrowserUploadUrl:'/panel/upload-image?type=Images',
            filebrowserImage2BrowseUrl:'/panel/upload-image?type=Images',
            filebrowserImageBrowseUrl: '/panel/upload-image?type=Images',
            filebrowserBrowseUrl: '/panel/upload-image?type=Files',
        });
    </script>

@endsection
