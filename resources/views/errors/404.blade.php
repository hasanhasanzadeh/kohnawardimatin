@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')

@section('message')
    <div class="container text-center">
        <div class="page-404-title pt-5">
            <h1>صفحه‌ای که دنبال آن بودید پیدا نشد!</h1>
        </div>
        <div class="page-404-image">
            <img src="{{asset('assets/img/404.png')}}" alt="">
        </div>
    </div>
@endsection
