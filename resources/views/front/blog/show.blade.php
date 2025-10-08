@extends('layouts.app')

@section('content')
        <div class="mx-3">
            <div class="w-full shadow rounded padding">
                <div class="p-4 m-4">
                    <h1 class="text-center my-4 py-4 h1 dark:text-gray-200">{{$article->title}}</h1>
                    <div class="flex justify-center dark:text-gray-200">
                        <img src="{{$article->photo->address}}" class="w-auto h-auto" alt="{{$article->title}}">
                    </div>
                    <p class="text-justify padding m-4 dark:text-gray-200">
                        {!! $article->description !!}
                    </p>
                </div>
                <div>
                    <div class="p-5 m-2">
                        <div class="flex justify-between">
                            <h1 class="my-2 h1 text-center dark:text-gray-200">@lang('front.similar_article')</h1>
                            <a href="{{route('article.all')}}" class="dark:text-gray-200">
                                {{__('front.blog')}}
                            </a>
                        </div>
                        <hr class="p-1 my-3">
                        <div class="flex flex-col flex-wrap w-fit  md:flex-row mb-10 md:w-1/2 justify-center">
                            @foreach($articles as $key=>$article)
                                <a href="{{route('article.show',$article->slug)}}" class="flex flex-col mb-5 mx-auto items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                                    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" src="{{$article->photo->address}}" alt="{{$article->title}}">
                                    <div class="flex flex-col justify-between p-4 leading-normal">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-200">
                                            {{$article->title}}
                                        </h5>
                                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-200 text-justify">
                                            {{$article->body}}
                                        </p>
                                        <div class="flex justify-center ">
                                            <i class="fa-solid fa-eye pt-1 dark:text-gray-200"></i>
                                            <span class="px-2 pt-0 dark:text-gray-200">{{$article->view_count}}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
