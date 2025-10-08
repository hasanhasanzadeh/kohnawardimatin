@extends('layouts.app')

@section('style')
    <style>
        .my-20 {
            margin-top: 100px !important;
            margin-bottom: 100px !important;
        }

        @media (min-width: 768px) {
            .search-help {
                width: 70%;
                margin: auto;
            }
        }

        @media (max-width: 768px) {
            .search-help {
                width: 95%;
                margin: auto;
            }
        }
    </style>
@endsection

@section('content')
    <div class="flex justify-center">
        <form class="search-help my-20">
            <label for="default-search"
                   class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">@lang('front.search')</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none"
                         stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="search" name="search" id="default-search"
                       class="block w-full p-4 text-center text-md text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="{{__('front.search')}}">
                <button type="submit"
                        class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('front.search')</button>
            </div>
        </form>
    </div>
    @if($advertises->isEmpty() )
        <div class="flex h-screen justify-center">
            <div style="margin-top: 100px;">
                <h1 class="text-center text-gray-900 dark:text-white text-center" style="font-size:3rem;">
                    @lang('front.advertiseNotExists')
                </h1>
                <h1 class="text-center text-gray-900 dark:text-white text-center my-7">
                    <i class="fa-solid fa-bullhorn" style="font-size:3rem;"></i>
                </h1>
            </div>
        </div>
    @else
        <div style="margin-top: 80px">
            <div class="grid grid-cols-1 md:grid-cols-4 mb-10 gap-4">
                @include('partials.product',['objects'=>$advertises])
            </div>
        </div>
        <div class="flex flex-wrap justify-center" dir="ltr">
            {{$advertises->links()}}
        </div>
        </div>
    @endif
@endsection
