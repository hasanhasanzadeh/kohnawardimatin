@extends('layouts.app')

@section('content')
    @php
        $setting=$helper['setting'];
        $steps=$helper['steps'];
        $brands_show=$helper['brands_show'];
        $products=$helper['products'];
        $specials=$helper['specials'];
        $product_cats=$helper['product_cats'];
        $banner=$helper['banner'];
        $banners=$helper['banners'];
        $sliders=$helper['sliders'];
        $page_cats=$helper['page_cats'];
        $articles_show=$helper['articles_show'];
        $cart=$helper['cart'];
        $bases=$helper['bases'];
        $categories=$helper['categories']; $coupon=$helper['coupon'];
    @endphp
    <div class="mx-3">
        <div class="w-full shadow rounded">
            <h1 class="text-center my-4 py-4 h1 dark:text-gray-200">@lang('front.blog')</h1>
            <div class="flex justify-center w-full">
                <form method="GET" class="w-full" style="width: 70%;">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">{{__('front.search')}}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="search" name="article" id="default-search" class="block w-full p-4 pl-10 text-center text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="{{__('dashboard.search')}}">
                        <button type="submit" class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">@lang('dashboard.search')</button>
                    </div>
                </form>
            </div>
            <div class="p-5 m-2">
                <hr class="p-1 my-3">
                    <div class="flex flex-col flex-wrap w-fit  md:flex-row mb-10 md:w-1/2 justify-center">
                        @foreach($articles as $key=>$article)
                            <a href="{{route('article.show',$article->slug)}}" class="flex flex-col mb-4 items-center bg-white border border-gray-200 mx-auto rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" src="{{$article->photo->address}}" alt="{{$article->title}}">
                                <div class="flex flex-col justify-between p-4 leading-normal">
                                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-200">
                                        {{$article->title}}
                                    </h5>
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-200 text-justify">
                                        {{$article->body}}
                                    </p>
                                    <div class="flex justify-center">
                                        <i class="fa-solid fa-eye pt-1 dark:text-gray-200"></i>
                                        <span class="px-2 pt-0 dark:text-gray-200">{{$article->view_count}}</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    @if($articles->links())
                        <div dir="ltr" class="flex justify-center w-full my-4 p-4 dark:text-gray-200">
                            {{$articles->appends(['article' => request('article')])->links()}}
                        </div>
                    @endif
            </div>
        </div>
    </div>
@endsection
