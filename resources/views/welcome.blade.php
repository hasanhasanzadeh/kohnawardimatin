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
        $categories=$helper['categories'];
        $coupon=$helper['coupon'];
    @endphp
        <main class="main default">
            <div class="container mt-md-3">
                <!-- banner -->
                @if($banner)
                    <div class="row banner-ads ">
                        <div class="col-12">
                            <section class="banner">
                                <a href="{{$banner->url}}" target="__blank">
                                    <img src="{{$banner->photo->address}}" height="auto" width="100%;" alt="{{$banner->category->name}}">
                                </a>
                            </section>
                        </div>
                    </div>
                @endif
                <!-- banner -->
               @if(!$sliders->isEmpty())
                    <div class="row">
                        <aside class="sidebar col-12 col-lg-3 order-2 order-lg-1">
                            <div class="sidebar-inner default">
                                <div class="widget-suggestion widget card">
                                    <header class="card-header">
                                        <h3 class="card-title">پیشنهاد لحظه ای</h3>
                                    </header>
                                    <div id="progressBar">
                                        <div class="slide-progress"></div>
                                    </div>
                                    <div id="suggestion-slider" class="owl-carousel owl-theme">
                                        @foreach($products as $product)
                                            <div class="item">
                                                <a href="{{url('/product/show/'.$product->slug)}}">
                                                    <img src="{{$product->photo->address}}" class="w-100" alt="{{$product->title}}" loading="lazy">
                                                </a>
                                                <h3 class="product-title">
                                                    <a href="#"> {{$product->title}} </a>
                                                </h3>
                                                <div class="price">
                                                    @if($product->discount >0)
                                                        <del><span class="amount">{{number_format($product->original_price,0)}}<span>@lang('dashboard.toman')</span></span></del>
                                                    @endif
                                                    <span class="amount">{{number_format($product->price,0)}}<span>@lang('dashboard.toman')</span></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </aside>
                        @if(!$sliders->isEmpty())
                            <div class="col-12 col-lg-9 order-1 order-lg-2">
                                <section id="main-slider" class="carousel slide carousel-fade card" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach($sliders as $key=>$slider)
                                            <li data-target="#main-slider" data-slide-to="{{$key}}" @if($key==0) class="active" @endif data-slide-to="{{$key++}}"></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach($sliders as $keys=>$slider)
                                            <div class="carousel-item @if($keys==0) active @endif">
                                                <a class="d-block" href="{{url('/category/show/'.$slider->category->slug)}}">
                                                    <img src="{{$slider->photo->address}}" class="d-block w-100 img-carousel" alt="{{$slider->slug}}" loading="lazy">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#main-slider" role="button" data-slide="prev">
                                        <i class="now-ui-icons arrows-1_minimal-right"></i>
                                    </a>
                                    <a class="carousel-control-next" href="#main-slider" data-slide="next">
                                        <i class="now-ui-icons arrows-1_minimal-left"></i>
                                    </a>
                                </section>
                            </div>
                        @endif
                    </div>
               @endif
                <div class="row">
                    <div class="col-12 order-2">
                        @if(!$specials->isEmpty())
                            <div class="row mx-2">
                                <section id="amazing-slider" class="carousel slide carousel-fade card" data-ride="carousel">
                                    <div class="row m-0">
                                        <ol class="carousel-indicators pr-0 d-flex flex-column col-lg-3">
                                            @foreach($specials as $lis=>$special)
                                                <li @if($lis==0) class="active" @endif data-target="#amazing-slider" data-slide-to="{{$lis}}">
                                                    <span>{{$special->title}}</span>
                                                </li>
                                            @endforeach
                                            <li class="view-all">
                                                <a href="{{url('/special/product')}}" class="btn btn-primary btn-block hvr-sweep-to-left">
                                                    <i class="fa fa-arrow-left"></i>مشاهده همه شگفت انگیزها
                                                </a>
                                            </li>
                                        </ol>
                                        <div class="carousel-inner p-0 col-12 col-lg-9">
                                            <img class="amazing-title" src="{{url('assets/img/amazing-slider/amazing-title-01.png')}}" alt="">
                                            @foreach($specials as $list=>$product)
                                                <div class="carousel-item @if($list==0) active @endif @if($product->expired_at < \Carbon\Carbon::now()) finished @endif">
                                                    <div class="row m-0">
                                                        <div class="right-col col-5 d-flex align-items-center">
                                                            <a class="w-100 text-center" href="{{url('/product/show/'.$product->slug)}}">
                                                                <img src="{{$product->photo->address}}" class="col-5 img-fluid" alt="{{$product->title}}" loading="lazy">
                                                            </a>
                                                        </div>
                                                        <div class="left-col col-7">
                                                            <div class="price">
                                                                @if($product->discount > 0)
                                                                <del><span>{{number_format($product->original_price,0)}}<span>@lang('dashboard.toman')</span></span></del>
                                                                @endif
                                                                <ins><span>{{number_format($product->price,0)}}<span>@lang('dashboard.toman')</span></span></ins>
                                                                <span class="discount-percent">{{$product->discount}} % تخفیف</span>
                                                            </div>
                                                            <h2 class="product-title">
                                                                <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}} </a>
                                                            </h2>
                                                            <div class="countdown-timer" countdown data-date="{{$product->expired_at}}">
                                                                <span data-days>0</span>:
                                                                <span data-hours>0</span>:
                                                                <span data-minutes>0</span>:
                                                                <span data-seconds>0</span>
                                                            </div>
                                                            <div class="timer-title">زمان باقی مانده تا پایان سفارش</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </section>
                            </div>
                            <div class="row" id="amazing-slider-responsive">
                                <div class="col-12">
                                    <div class="widget widget-product card">
                                        <header class="card-header">
                                            <img src="{{url('assets/img/amazing-slider/amazing-title-01.png')}}" width="150px" alt="">
                                            <a href="{{url('/special/product')}}" class="view-all">مشاهده همه</a>
                                        </header>
                                        <div class="product-carousel owl-carousel owl-theme">
                                            @foreach($specials as $li=>$product)
                                            <div class="item">
                                                @if($product->discount>0)
                                                    <div class="label-check">{{$product->discount}} % -</div>
                                                @endif
                                                    @if($product->discount < 1 || $product->status=='soon')
                                                        <div class="label-check mt-5">ناموجود</div>
                                                    @endif
                                                <a href="{{url('/product/show/'.$product->slug)}}">
                                                    <img src="{{$product->photo->address}}"
                                                         class="img-fluid" alt="{{$product->title}}" loading="lazy">
                                                </a>
                                                <h2 class="post-title">
                                                    <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}}</a>
                                                </h2>
                                                <div class="price">
                                                        @if($product->discount >0)
                                                            <del><span class="amount">{{number_format($product->original_price,0)}}<span>@lang('dashboard.toman')</span></span></del>
                                                        @endif
                                                        <span class="amount">{{number_format($product->price,0)}}<span>@lang('dashboard.toman')</span></span>
                                                </div>
                                                <hr>
                                                <div class="countdown-timer" countdown data-date="{{$product->expired_at}}">
                                                    <span data-days>0</span>:
                                                    <span data-hours>0</span>:
                                                    <span data-minutes>0</span>:
                                                    <span data-seconds>0</span>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($sliderTop=App\Models\Slider::where('status',true)->where('rang','step-2')->latest()->take(4)->get())
                           <div class="row banner-ads">
                                    <div class="col-12">
                                        <div class="row">
                                            @foreach($sliderTop as $slid)
                                                    <div class="col-12 col-md-6">
                                                        <div class="widget widget-banner card bg-none">
                                                            <a href="{{url('/category/show/'.$slid->category->slug)}}" target="_blank">
                                                                <img class="img-fluid" src="{{$slid->photo->address}}" alt="{{$slid->category->name}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(!$steps->isEmpty())
                            <div class="row banner-ads">
                                <div class="col-12">
                                    <div class="row">
                                        @php
                                        $stp=0;
                                        @endphp
                                        @foreach($steps as $step)
                                            @if($step->rang=='step-4' && $stp<=3)
                                                <div class="col-6 col-md-3">
                                                    <div class="widget-banner card bg-none">
                                                        <a href="{{url('/category/show/'.$step->category->slug)}}" target="_blank">
                                                            <img class="img-fluid" src="{{$step->photo->address}}" alt="{{$step->category->name}}">
                                                        </a>
                                                    </div>
                                                </div>
                                                @php
                                                    $stp++;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if(!$new_products->isEmpty())
                                <div class="row">
                                    <div class="col-12">
                                        <div class="widget widget-product card">
                                            <header class="card-header">
                                                <h3 class="card-title">
                                                    <span>محصولات جدید</span>
                                                </h3>
                                                <a href="{{url('/products/search?title=')}}" class="view-all">مشاهده همه محصولات</a>
                                            </header>
                                            <div class="product-carousel owl-carousel owl-theme">
                                                @foreach($new_products as $product)
                                                    <div class="item">
                                                        @if($product->discount > 0)
                                                            <div class="label-check">{{$product->discount}} % -</div>
                                                        @endif
                                                        @if($product->quantity < 1 || $product->status=='soon')
                                                                <div class="label-check mt-5"> ناموجود </div>
                                                        @endif
                                                        <a href="{{url('/product/show/'.$product->slug)}}">
                                                            <img src="{{$product->photo->address}}"
                                                                 class="h-200 img-fluid" alt="{{$product->title}}">
                                                        </a>
                                                        <h2 class="post-title">
                                                            <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}}</a>
                                                        </h2>
                                                        <div class="price">
                                                            @if($product->discount >0)
                                                                <div class="text-center">
                                                                    <del><span>{{number_format($product->original_price,0)}}<span>@lang('dashboard.toman')</span></span></del>
                                                                </div>
                                                            @endif
                                                            <div class="text-center">
                                                                <ins><span>{{number_format($product->price,0)}}<span>@lang('dashboard.toman')</span></span></ins>
                                                            </div>

                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                       @endif
                        @if(!$product_cats->isEmpty())
                                @foreach($product_cats as $cats=>$cat)

{{--                                    @php--}}
{{--                                        $num=$product_cats->count();--}}
{{--                                    @endphp--}}

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="widget widget-product card">
                                                <header class="card-header">
                                                    <h3 class="card-title">
                                                        <span>{{$cat->name}}</span>
                                                    </h3>
                                                    <a href="{{url('/category/show/'.$cat->slug)}}" class="view-all">مشاهده همه</a>
                                                </header>
                                                <div class="product-carousel owl-carousel owl-theme">
                                                    @foreach($cat->products as $product)
                                                        <div class="item">
                                                        @if($product->discount>0)
                                                            <div class="label-check">{{$product->discount}} % -</div>
                                                        @endif
                                                        @if($product->quantity < 1 || $product->status=='soon')
                                                                <div class="label-check mt-5"> ناموجود </div>
                                                        @endif
                                                        <a href="{{url('/product/show/'.$product->slug)}}">
                                                            <img src="{{$product->photo->address}}"
                                                                 class="h-200 img-fluid" alt="{{$product->title}}">
                                                        </a>
                                                        <h2 class="post-title">
                                                            <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}}</a>
                                                        </h2>
                                                        <div class="price">
                                                            @if($product->discount >0)
                                                            <div class="text-center">
                                                                <del><span>{{number_format($product->original_price,0)}}<span>@lang('dashboard.toman')</span></span></del>
                                                            </div>
                                                            @endif
                                                            <div class="text-center">
                                                                <ins><span>{{number_format($product->price,0)}}<span>@lang('dashboard.toman')</span></span></ins>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
{{--                                    @if($cats==round($categories->count()/4))--}}
{{--                                        <div class="row banner-ads">--}}
{{--                                            <div class="col-12">--}}
{{--                                                <div class="row">--}}
{{--                                                    @php--}}
{{--                                                        $start=0;--}}
{{--                                                    @endphp--}}
{{--                                                    @foreach($steps as $step)--}}
{{--                                                        @if($step->rang=='step-2' && $start<2)--}}
{{--                                                            <div class="col-12 col-md-6">--}}
{{--                                                                <div class="widget-banner card bg-none">--}}
{{--                                                                    <a href="{{url('/category/show/'.$step->category->slug)}}" target="_top">--}}
{{--                                                                        <img class="img-fluid" src="{{$step->photo->address}}" alt="{{$step->name}}">--}}
{{--                                                                    </a>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                            @php--}}
{{--                                                                $start++;--}}
{{--                                                            @endphp--}}
{{--                                                        @endif--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                    @if($cats==round($categories->count()/2))--}}
{{--                                        <div class="row banner-ads">--}}
{{--                                            <div class="col-12">--}}
{{--                                                <div class="row">--}}
{{--                                                    @php--}}
{{--                                                    $str=0;--}}
{{--                                                    @endphp--}}
{{--                                                    @foreach($banners as $step)--}}
{{--                                                        @if($step->rang=='step-3' && $str<1)--}}
{{--                                                        <div class="col-12 col-md-4">--}}
{{--                                                            <div class="widget widget-banner card bg-none">--}}
{{--                                                                <a href="{{url('/category/show/'.$step->category->slug)}}" target="_blank">--}}
{{--                                                                    <img class="img-fluid" src="{{$step->photo->address}}" alt="{{$step->name}}">--}}
{{--                                                                </a>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                            @php--}}
{{--                                                                $str++;--}}
{{--                                                            @endphp--}}
{{--                                                        @endif--}}
{{--                                                    @endforeach--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
                                @endforeach
                            @endif
                            @if(App\Models\Slider::where('status',true)->where('rang','link')->get()->count() > 0 )
                                <div class="row banner-ads">
                                    <div class="col-12">
                                        <div class="row">
                                            @php
                                                $str=0;
                                            @endphp
                                            @foreach($banners as $step)
                                                @if($step->rang=='link')
                                                    <div class="col-12">
                                                        <div class="widget widget-banner card bg-none">
                                                            <a href="{{$step->url}}" target="_blank">
                                                                <img class="img-fluid" src="{{$step->photo->address}}" alt="{{$step->name}}">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    @php
                                                        $str++;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
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
                                        <div class="item height-200" >
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
                @if(!$articles_show->isEmpty())
                    <div class="row">
                        <div class="col-12">
                            <div class="brand-slider card">
                                <header class="card-header">
                                    <h3 class="card-title"><span>مقالات</span></h3>
                                    <a href="{{url('/article')}}" class="view-all">مشاهده همه</a>
                                </header>
                                <div class="owl-carousel">
                                    @foreach($articles_show as $article)
                                        <div class="item">
                                            <a href="{{url('/article/show/'.$article->slug)}}">
                                                <img src="{{$article->photo->address}}" style="height:240px !important;" alt="{{$article->title}}">
                                            </a>
                                            <h6 class="post-title py-3">
                                                <a href="{{url('/article/show/'.$article->slug)}}">{{$article->title}}</a>
                                            </h6>
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

@section('meta')
    <meta property="og:url" content="{{url('/')}}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{url('/')}}">
    <script type="application/ld+json">
        {
          "@context": "{{url('/')}}",
          "@type": "WebSite",
          "name": "{{$setting->title}}",
          "image": "{{$setting->logo->address??''}}",
          "description": "{{$setting->about}}",
        }
    </script>
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
