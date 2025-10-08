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
    <main class="container default">
        <div class="container card">
            <div class="row my-4">
                <div class="col-12">
                    <h2 class="m-4">{{$page->title}}</h2>
                </div>
                <div class="col-12 text-center">
                        <img src="{{$page->photo->address}}" alt="" class="mx-auto">
                </div>
                <div class="col-12">
                        {!! $page->description !!}
                </div>
            </div>
        </div>
    </main>
@endsection
