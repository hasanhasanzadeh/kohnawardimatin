@extends('layouts.app')

@section('meta')
    <meta property="og:url" content="{{url('/article/show/'.$article->slug)}}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{url('/article/show/'.$article->slug)}}">
    <script type="application/ld+json">
        {
          "@context": "{{url('/article/show/'.$article->slug)}}",
          "@type": "Article",
          "name": "{{$article->title}}",
          "image": "{{$article->photo??$article->photo->address}}",
          "description": "{{$article->description}}",
        }
    </script>
@endsection

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
    <main class="default">
        <div class="container">
            <div class="row">
                <div class="cart-page-content col-12 order-0">
                    <section class="page-content default">
                        <div class="order-info default">
                            <div class="h3 text-center">{{ $article->title }}</div>

                            <hr>
                            <br>
                            <div class="text-center">
                                <img src="{{ $article->photo->address }}" alt="{{$article->title}}" class="mx-auto">
                            </div>
                            <p class="text-justify h6">
                                {!! $article->body !!}
                            </p>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div id="products" class="col-12 order-1">
                    <div class="breadcrumb-section default">
                        <ul class="breadcrumb-list">
                            <li>
                                <a href="{{ url('/') }}">
                                    <span>فروشگاه اینترنتی {{ $setting->title }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/article') }}">
                                    <span>بلاگ</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('/article/show/'.$article->slug) }}">
                                    <span>{{$article->title}}</span>
                                </a>
                            </li>
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
                                        @foreach($articles as $article_show)

                                            <li class="col-xl-3 col-lg-4 col-md-6 col-12 no-padding">

                                                <div class="product-box">
                                                    <div class="product-seller-details product-seller-details-item-grid">
                                                        <span class="product-main-seller">
                                                            <i class="fas fa-pen-alt"></i>
                                                            <span class="product-seller-details-label">نویسنده:
                                                            </span>{{$article_show->user->full_name}}</span>
                                                        <span class="product-seller-details-badge-container"></span>
                                                    </div>
                                                    <a class="product-box-img" href="{{ url('/article/show/'.$article_show->slug) }}" >
                                                        <img src="{{ $article_show->photo->address }}" alt="{{$article->title}}">
                                                    </a>
                                                    <div class="product-box-content">
                                                        <div class="product-box-content-row">
                                                            <div class="product-box-title">
                                                                <a href="{{ url('/article/show/'.$article_show->slug) }}">
                                                                    {{ $article_show->title }}
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


@endsection
