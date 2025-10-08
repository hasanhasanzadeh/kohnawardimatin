@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('categories.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.categories')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('categories.update',$category->id)}}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$category->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="name">
                                {{__('dashboard.name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="name" name="name" type="text" value="{{$category->name}}" placeholder="{{__('dashboard.enterName')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="slug">
                                {{__('dashboard.slug')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="slug" name="slug" type="text" value="{{$category->slug}}" placeholder="{{__('dashboard.enterSlug')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="parent_id" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.parent')}}</label>
                            <select name="parent_id" id="parent_id" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                @if($category->parent_id!=0)
                                    @foreach(\App\Models\Category::all() as $subcategory)
                                        <option value="{{$subcategory->id}}" @if($subcategory->id==$category->parent_id) selected @endif>{{$subcategory->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" @if($category->status==1) selected @endif>{{__('dashboard.active')}}</option>
                                <option value="0" @if($category->status==0) selected @endif>{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>$category->photo?$category->photo:null])
                        @include('panel.partials.meta_edit',['object'=>$category])
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
    <script >
        $('#parent_id').select2({
            placeholder: '{{__('dashboard.category')}}',
            ajax: {
                url: '{{route('category.search')}}',
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
        $("#name").keyup(function() {
            let title=$('#name').val();
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
