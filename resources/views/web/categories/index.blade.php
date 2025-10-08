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
        <!-- main -->
    <main class="search-page default">
        <div class="container">
            <div class="row"></div>
            <div class="row">
                <h1 class="font-normal p-4 m-5 fa-2xl">دسته بندی های  {{$setting->title}}</h1>
            </div>
            <div class="row">
                @foreach($cats as $cat)
                    @if($cat->photo)
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="widget widget-banner card bg-none">
                                <a href="{{url('/category/show/'.$cat->slug)}}" target="_blank" title="{{$cat->name}}">
                                    <img class="img-fluid" src="{{$cat->photo->address}}" alt="{{$cat->name}}">
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </main>
    <!-- main -->

@endsection
