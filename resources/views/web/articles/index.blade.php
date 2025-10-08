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
            <div class="row">
                <div id="products" class="col-12 order-0">
                    <div class="breadcrumb-section default">
                        <ul class="breadcrumb-list">
                            <li>
                                <a href="{{ url('/') }}">
                                    <span>فروشگاه اینترنتی {{ $setting->title }}</span>
                                </a>
                            </li>
                            <li><span>بلاگ </span></li>
                        </ul>
                    </div>
                    <div class="listing default">
                        <div class="listing-counter">{{ $articles->count() }} </div>
                        <div class="listing-header default">
                            <ul class="listing-sort nav nav-tabs justify-content-center" role="tablist"
                                data-label="مرتب‌سازی بر اساس :">
                                <table>
                                    <thead>
                                    <tr class="text-info">
                                        <th class="px-3 mx-2 d-block d-md-inline-block text-right">@sortablelink('title', 'مرثب سازی بر اساس نام')</th>
                                        <th class="px-3 mx-2 d-block d-md-inline-block text-right">@sortablelink('created_at', 'جدیدترین ها و قدیمترین ها')</th>
                                    </tr>
                                    </thead>
                                </table>
                            </ul>
                        </div>
                        <div class="default text-center">
                            <div class=" active" id="related">
                                <div class="container no-padding-right">
                                    <ul class="row listing-items">
                                        @foreach($articles as $key => $article)

                                            <li class="col-xl-3 col-lg-4 col-md-6 col-12 no-padding">

                                                <div class="product-box">
                                                    <div class="product-seller-details product-seller-details-item-grid">
                                                        <span class="product-main-seller">
                                                            <i class="fas fa-pen-alt"></i>
                                                            <span class="product-seller-details-label">نویسنده:
                                                            </span>{{$article->user->full_name}}</span>
                                                        <span class="product-seller-details-badge-container"></span>
                                                    </div>
                                                    <a class="product-box-img" href="{{ url('/article/show/'.$article->slug) }}">
                                                        <img src="{{ $article->photo->address }}" alt="{{$article->title}}">
                                                    </a>
                                                    <div class="product-box-content">
                                                        <div class="product-box-content-row">
                                                            <div class="product-box-title">
                                                                <a href="{{ url('/article/show/'.$article->slug) }}">
                                                                    {{ $article->title }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pager default text-center">
                            <ul class="pager-items">
                                <li class="py-2 my-2 text-info">
                                    {!! $articles->appends(Request::except('page'))->render('pagination::bootstrap-4') !!}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main -->

@endsection
