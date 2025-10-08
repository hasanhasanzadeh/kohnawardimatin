@extends('layouts.app')

@section('content')
        <div class="mx-3 bg-white md-mt-10">
            <div class=" shadow rounded p-1 md-p-5">
                <h1 class="text-center my-4 py-4 text-xl">{{$page->title}}</h1>
                @if($page->photo_id)
                    <div class="flex justify-center">
                        <img src="{{$page->photo->address}}" class="w-auto h-auto" width="200" height="200" alt="{{$page->title}}">
                    </div>
                @endif
                <div class="p-4 m-2">
                    <p class="text-justify dark:text-gray-200">
                        {!! $page->description !!}
                    </p>
                </div>
            </div>
        </div>
@endsection
