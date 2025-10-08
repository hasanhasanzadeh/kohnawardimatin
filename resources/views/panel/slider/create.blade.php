@extends('panel.layouts.panel')


@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('sliders.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.sliders')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('sliders.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="category_id">
                                {{__('dashboard.category')}}
                            </label>
                            <select name="category_id" id="category_id" class="appearance-none dark:bg-gray-700 dark:text-gray-200 px-10 block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">

                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="url">
                                {{__('dashboard.url')}}
                            </label>
                            <input type="url" value="{{old('url')}}" name="url" id="url" class="appearance-none dark:bg-gray-700 dark:text-gray-200 block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" />
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="type">
                                {{__('dashboard.type')}}
                            </label>
                            <select name="rang" id="type" class="appearance-none  block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-10 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="slider" selected>@lang('dashboard.slider')</option>
                                <option value="step-1">@lang('dashboard.step-1')</option>
                                <option value="step-2">@lang('dashboard.step-2')</option>
                                <option value="step-3">@lang('dashboard.step-3')</option>
                                <option value="step-4">@lang('dashboard.step-4')</option>
                                <option value="banner">@lang('dashboard.banner')</option>
                                <option value="link">@lang('dashboard.link')</option>
                            </select>
                        </div>
                        <div class="w-full md:w-1/2 px-3  my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" selected>{{__('dashboard.active')}}</option>
                                <option value="0">{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>null])
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
    <script>
        $('#category_id').select2({
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
    </script>

@endsection

