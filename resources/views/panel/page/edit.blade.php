@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('pages.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.pages')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('pages.update',$page->id)}}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$page->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" value="{{$page->title}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="slug">
                                {{__('dashboard.slug')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="slug" name="slug" type="text" value="{{$page->slug}}" placeholder="{{__('dashboard.enterSlug')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="page_cat_id">
                                {{__('dashboard.page_cat_select')}}
                            </label>
                            <select name="page_cat_id" class="appearance-none px-10 block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 focus:outline-none focus:bg-white focus:border-gray-500 text-left" id="page_cat_id">
                                @if($page->page_cat_id)
                                    <option value="{{$page->page_cat_id}}" selected>{{$page->page_cat->name}}</option>
                                @endif
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" @if($page->status==1) selected @endif>{{__('dashboard.active')}}</option>
                                <option value="0" @if($page->status==0) selected @endif>{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>$page->photo?$page->photo:null])
                        <div class="w-full px-3  my-3">
                            <label for="description" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.description')}} </label>
                            <textarea name="description" class="form-textarea appearance-none block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" placeholder="{{__('dashboard.enterDescription')}}" id="description" cols="30" rows="10">{!! $page->description!!}</textarea>
                        </div>
                        @include('panel.partials.meta_edit',['object'=>$page])
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
        })
        $('#page_cat_id').select2({
            placeholder: '{{__('dashboard.page_cat_select')}}',
            ajax: {
                url: '{{route('page_cat.search')}}',
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
    </script>

@endsection

