@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('symbols.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.symbols')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{route('symbols.update',$symbol->id)}}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$symbol->id}}">
                    <div class="flex flex-wrap mx-3 my-2">
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="title" name="title" type="text" value="{{$symbol->title}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="url">
                                {{__('dashboard.url')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="url" name="url" type="text" value="{{$symbol->url}}" placeholder="{{__('dashboard.enterUrl')}}">
                        </div>

                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="setting_id" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.settings')}}</label>
                            <select name="setting_id" class="appearance-none px-10 block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="setting_id">
                                @foreach(\App\Models\Setting::all() as $setting)
                                    <option value="{{$setting->id}}" @if($symbol->setting_id==$setting->id) selected @endif>
                                        {{$setting->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>$symbol->photo?$symbol->photo:null])
                        <div class="w-full px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="description">
                                {{__('dashboard.description')}}
                            </label>
                            <textarea class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" rows="5" id="description" name="description"  placeholder="{{__('alert.enterDescription')}}">{{$symbol->description}}</textarea>
                        </div>
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
