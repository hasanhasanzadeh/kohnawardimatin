@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('articles.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.articles')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('articles.update',$article->id)}}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$article->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700  dark:bg-gray-700 dark:text-gray-200  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" value="{{$article->title}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="slug">
                                {{__('dashboard.slug')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700  dark:bg-gray-700 dark:text-gray-200  rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="slug" name="slug" type="text" value="{{$article->slug}}" placeholder="{{__('dashboard.enterSlug')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="publish_date">
                                تاریخ انتشار مقاله
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="publish_date" name="publish_date" type="date" value="{{\Carbon\Carbon::parse($article->publish_date)->format('Y-m-d')}}" placeholder="تاریخ انتشار مقاله">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none  dark:bg-gray-700 dark:text-gray-200  block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" @if($article->status==1) selected @endif>{{__('dashboard.active')}}</option>
                                <option value="0" @if($article->status==0) selected @endif>{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>$article->photo?$article->photo:null])
                        <div class="w-full px-3 my-3">
                            <label for="description" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.description')}} </label>
                            <textarea name="description" class="form-textarea appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="description" cols="30" rows="4">{!!$article->description!!}</textarea>
                        </div>
                        <div class="w-full px-3 my-3">
                            <label for="body" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.body')}} </label>
                            <textarea name="body" class="form-textarea appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="body" cols="30" rows="10">{!!$article->body!!}</textarea>
                        </div>
                        @include('panel.partials.meta_edit',['object'=>$article])
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
    <script src="{{url('/plugin/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('body',{
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
    </script>

@endsection
