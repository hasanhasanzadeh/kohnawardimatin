@extends('layouts.app')

@section('content')
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
        <div class="my-10">
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
