@extends('panel.layouts.panel')

@section('content')
    <div class="container px-6 mx-auto grid">
        <span class="my-6 text-2xl font-semi bold text-gray-700 dark:text-gray-200">
            {{$title}}
        </span>
        <a href="{{route('roles.index')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-auto">
            <i class="fa fa-list"></i>
            {{__('dashboard.roles')}}
        </a>
        <!-- New Table -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs" >
            <div class="w-full overflow-x-auto">
                <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">
                    <form method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label for="name" class="block text-sm font-medium dark:text-gray-50 text-gray-700"> {{__('dashboard.name')}}</label>
                            <div class="mt-1">
                                <input type="text" id="name" name="name" value="{{old('name')}}" class="block w-full appearance-none dark:bg-gray-700 dark:text-gray-200 bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5" />
                            </div>
                        </div>
                        <div class="w-full md:w-1/2 px-3 my-3">
                            <label class="block uppercase tracking-wide text-gray-700 dark:text-gray-50 font-bold mb-2" for="display_name">
                                {{__('dashboard.display_name')}}
                            </label>
                            <input class="appearance-none block w-full bg-gray-200 dark:bg-gray-700 dark:text-gray-200 text-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="display_name" name="display_name" type="text" value="{{old('display_name')}}" placeholder="{{__('dashboard.display_name')}}">
                        </div>
                        <div class="w-full px-3 my-3">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">@lang('dashboard.store')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

