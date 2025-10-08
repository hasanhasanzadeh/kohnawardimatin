@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('bases.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.bases')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <form class="w-full" method="post" action="{{ route('bases.update',$base->id) }}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PATCH')}}
                    <input type="hidden" name="id" value="{{$base->id}}">
                    <div class="flex flex-wrap mx-3 mb-6">
                        <div class="w-full px-3  my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="title">
                                {{__('dashboard.title')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="title" name="title" type="text" value="{{$base->title}}" placeholder="{{__('dashboard.enterTitle')}}">
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="status" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.status')}}</label>
                            <select name="status" id="status" class="form-select appearance-none block w-full dark:bg-gray-700 dark:text-gray-200 bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-14 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="1" @if($base->status==1) selected @endif>{{__('dashboard.active')}}</option>
                                <option value="0" @if($base->status==0) selected @endif>{{__('dashboard.inactive')}}</option>
                            </select>
                        </div>
                        @include('panel.partials.photo',['photo'=>$base->photo?$base->photo:null])
                        <div class="w-full px-3 my-3">
                            <label for="body" class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2">{{__('dashboard.description')}} </label>
                            <textarea name="description" class="form-textarea appearance-none block dark:bg-gray-700 dark:text-gray-200 w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="body" cols="30" rows="10">{!!$base->description!!}</textarea>
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

