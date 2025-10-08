@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('medias.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.medias')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{ route('medias.update',$media->id) }}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$media->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3 md:w-1/2 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" value="{{$media->title}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="link">
                                {{__('dashboard.link')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="link" name="link" type="text" value="{{$media->link}}" placeholder="{{__('dashboard.enterLink')}}">
                        </div>
                        @include('panel.partials.photo',['photo'=>$media->photo??null])
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

