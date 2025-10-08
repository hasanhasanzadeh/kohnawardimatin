@extends('layouts.app')

@section('meta')
    <meta property="og:url" content="{{url('/brand/show/'.$brand_show->slug)}}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{url('/brand/show/'.$brand_show->slug)}}">
    <script type="application/ld+json">
        {
          "@context": "{{url('/brand/show/'.$brand_show->slug)}}",
          "@type": "Brand",
          "name": "{{$brand_show->title}}",
          "image": "{{$brand_show->photo??$brand_show->photo->address}}",
          "description": "{{$brand_show->description}}",
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
    <main class="default margin-top">
        <div class="container">
            <div class="row">
                    <div class="cart-page-content col-12 order-1">
                        <section class="page-content default">
                            <div class="order-info default">
                                <h3>نام برند : <span>{{ $brand_show->title }}</span></h3>

                                    <hr>
                                    <br>
                                    <div class="text-center">
                                        <img src="{{ $brand_show->photo->address }}" alt="{{$brand_show->title}}" height="200" width="240">
                                    </div>
                                    <p class="text-justify">
                                        {!! $brand_show->description !!}
                                    </p>
                            </div>
                        </section>
                    </div>
            </div>

            @if(!$showProducts->isEmpty())
                    <div class="row">
                        <div class="col-12">
                            <div class="widget widget-product card">
                                <header class="card-header">
                                    <h3 class="card-title">
                                        <span>{{$brand_show->title}}</span>
                                    </h3>
                                    <a href="{{url('/products/search?'.'brand[]='.$brand_show->id)}}" class="view-all">مشاهده همه</a>
                                </header>
                                <div class="product-carousel owl-carousel owl-theme">
                                    @foreach($showProducts as $product)
                                    <div class="item">
                                        @if($product->discount > 0)
                                            <div class="label-check">{{$product->discount}} % -</div>
                                        @endif
                                        @if($product->discount < 1 || $product->status=='soon')
                                            <div class="label-check mt-5">ناموجود</div>
                                        @endif
                                        <a href="{{url('/product/show/'.$product->slug)}}" >
                                            <img src="{{$product->photo->address}}" class="height-200"  alt="{{$product->title}}">
                                        </a>
                                        <h2 class="post-title">
                                            <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}}</a>
                                        </h2>
                                        <div class="price">
                                                <div class="text-center">
                                                    <ins><span>{{number_format($product->price,0) }}<span> تومان</span></span></ins>
                                                </div>
                                        </div>
                                    </div>

                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

            @if(!$brands_show->isEmpty())
                <div class="row my-2">
                    <div class="col-12">
                        <div class="brand-slider card">
                            <header class="card-header">
                                  <h3 class="card-title"><span>برندهای ویژه</span></h3>
                                <a href="{{url('/brands/all')}}" class="view-all">نمایش همه برندها</a>
                            </header>
                            <div class="owl-carousel">
                                @foreach($brands_show as $brand)
                                <div class="item">
                                    <a href="{{url('/brand/show/'.$brand->slug)}}">
                                        <img src="{{$brand->photo->address}}" class="height-200" alt="{{$brand->title}}">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </main>
@endsection
@section('style')
    <style>
        @media (min-width:450px){
            .height-200{
                height:200px!important;
            }
        }
        @media (max-width:450px){
            .height-200{
                height:auto !important;
            }
        }
        .gallery_m{
            width:100% !important;
            float:center;
            margin-top:500px !important;
        }
        .zoom-image{

        }

    </style>
@endsection
