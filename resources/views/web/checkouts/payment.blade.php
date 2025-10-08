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
    <div class="wrapper default shopping-page md-mt-10">
        <!-- header-shopping -->
        <header class="header-shopping default">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <ul class="checkout-steps">
                            <li>
                                <a href="{{route('checkouts.index')}}" class="active">
                                    <span>اطلاعات ارسال</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="{{route('checkouts.payment')}}" class="active">
                                    <span>پرداخت</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span>اتمام خرید و ارسال</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <!-- header-shopping -->
    </div>
    <!-- main-shopping -->
    <main class="cart-page default margin-top-0">
        <div class="container">
            <div class="row">
                <div class="cart-page-content col-xl-9 col-lg-8 col-md-12 order-1">
                    <div class="cart-page-title">
                        <h1>انتخاب شیوه پرداخت</h1>
                    </div>
                    <section class="page-content default">
                        <form action="">
                            <ul class="checkout-paymethod">
                                <li>
                                    <div class="checkout-paymethod-item checkout-paymethod-item-cc has-options">
                                        <div class="radio">
                                            <input type="radio" name="radio" id="radio1" value="option1" checked>
                                            <label for="radio1">
                                                <div>
                                                    <h4 class="checkout-paymethod-title">
                                                        <div>
                                                            <p class="checkout-paymethod-title-label">
                                                                پرداخت اینترنتی ( آنلاین با تمامی کارت‌های بانکی )
                                                            </p>
                                                        </div>
                                                        <span>سرعت بیشتر در ارسال و پردازش سفارش </span>
                                                    </h4>
                                                    <div class="checkout-paymethod-one-gateway">
                                                        <div class="checkout-paymethod-one-gateway-img">
                                                            <img src="{{asset('/images/zarinpal.png')}}" class="img-fluid" alt="">
                                                        </div>
                                                        درگاه زرین پال - سامانه پرداخت هوشمند {{$setting->title}}
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </form>
                        <div class="headline my-3">
                            <span>خلاصه سفارش</span>
                        </div>
                        <div class="checkout-order-summary">
                            <div class="accordion checkout-order-summary-item" id="accordionExample">
                                <div class="card">
                                    <div class="card-header checkout-order-summary-header" id="headingOne">
                                        <h2 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#collapseOne" aria-expanded="false"
                                                    aria-controls="collapseOne">
                                                <div class="checkout-order-summary-row">
                                                    <div
                                                        class="checkout-order-summary-col checkout-order-summary-col-post-time">
                                                        مرسوله
                                                        <span class="fs-sm">({{$cart->quantity}} کالا)</span>
                                                    </div>
                                                    <div
                                                        class="checkout-order-summary-col checkout-order-summary-col-how-to-send">
                                                        <span class="dl-none-sm">نحوه ارسال</span>
                                                        <span class="dl-none-sm">
                                                                @if($cart->post_id)
                                                                   {{$cart->post->title}}
                                                                @endif
                                                            </span>
                                                    </div>
                                                    <div
                                                        class="checkout-order-summary-col checkout-order-summary-col-how-to-send">
                                                        <span>ارسال از</span>
                                                        <span class="fs-sm">
                                                                1 روز کاری
                                                            </span>
                                                    </div>
                                                    <div
                                                        class="checkout-order-summary-col checkout-order-summary-col-shipping-cost">
                                                        <span>هزینه ارسال</span>
                                                        <span class="fs-sm text-danger">
                                                            @if($cart->post_id)
                                                                {{number_format($cart->post_price,0).' '.'تومان'}}
                                                                @if($cart->post->payment_state)
                                                                    <span class="px-2">{{__('dashboard.so_rent')}}</span>
                                                                @else
                                                                    <span class="px-2">{{__('dashboard.advance_rent')}}</span>
                                                                @endif
                                                            @else
                                                                بستگی به انتخاب نحوی ارسال
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                                <i class="now-ui-icons arrows-1_minimal-down icon-down"></i>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                         data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="box">
                                                <div class="row">
                                                    @foreach($cart->products as $product)
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 text-center bg-white shadow">
                                                        <div class="product-box-container">
                                                            <div class="product-box product-box-compact">
                                                                <a class="product-box-img" href="{{url('/product/show/'.$product->slug)}}">
                                                                    <img alt="" src="{{$product->photo->address}}">
                                                                </a>
                                                                <div class="product-box-title">
                                                                    <a href="{{url('/product/show/'.$product->slug)}}">
                                                                        {{$product->title}}
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(App\Models\Coupon::whereDate('expired_at','>=',\Carbon\Carbon::now()->format('Y-m-d'))->where('status',true)->get()->count())
                        <div class="row">
                            <div class="col-12">
                                <div class="checkout-price-options">
                                    <div class="checkout-price-options-form">
                                        <section class="checkout-price-options-container">
                                            <div class="checkout-price-options-header">
                                                <span>استفاده از کد تخفیف {{$setting->title}}</span>
                                            </div>
                                            <div class="checkout-price-options-content">
                                                <p class="checkout-price-options-description">
                                                    با ثبت کد تخفیف، مبلغ کد تخفیف از “مبلغ قابل پرداخت” کسر می‌شود.
                                                </p>
                                                <form action="{{route('coupons.add')}}" method="POST">
                                                    @csrf
                                                    <div class="checkout-price-options-row">
                                                        <div class="checkout-price-options-form-field">
                                                            <label class="ui-input">
                                                                <input class="ui-input-field"  name="code" type="text" placeholder="مثلا 837A2CS">
                                                            </label>
                                                        </div>
                                                        <div class="checkout-price-options-form-button">
                                                            <button type="submit" class="btn-primary">
                                                                ثبت کد تخفیف
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </section>
                </div>
                <aside class="cart-page-aside col-12 col-sm-6 col-md-4 col-lg-3 center-section order-0 md:order-1">
                    <div class="shipping-data-form">
                        <div class="headline my-3">
                            <span>مبلغ سفارشات شما</span>
                        </div>
                        <div class="checkout-summary">
                            <div class="checkout-summary-main">
                                <ul class="checkout-summary-summary">
                                    <li>
                                        <span>مبلغ کل ({{$cart->quantity}} کالا)</span>
                                        <span>{{ number_format($cart->sum_price,0) }} تومان</span>
                                    </li>
                                    @if($cart->coupon_id)
                                        <li>
                                            <span>درصد تخفیف</span>
                                            <span>{{ $cart->coupon->discount }} درصد </span>
                                        </li>
                                    @endif
                                    <li>
                                        <span>هزینه ارسال</span>
                                        <span>
                                             @if($cart->post_id)
                                                {{number_format($cart->post_price,0).' '.'تومان'}}
                                                @if($cart->post->payment_state)
                                                    <span class="px-2">{{__('dashboard.so_rent')}}</span>
                                                @else
                                                    <span class="px-2">{{__('dashboard.advance_rent')}}</span>
                                                @endif
                                            @else
                                                بستگی به انتخاب شیوه ارسال
                                            @endif
                                            </span>
                                    </li>
                                </ul>
                                <div class="checkout-summary-devider">
                                    <div></div>
                                </div>
                                <div class="checkout-summary-content">
                                    <div class="checkout-summary-price-title">مبلغ قابل پرداخت:</div>
                                    <div class="checkout-summary-price-value">
                                            <span class="checkout-summary-price-value-amount">
                                                @if($cart->post_id)
                                                    <span> {{number_format($cart->total_price,0)}}</span>
                                                @else
                                                    <span> {{number_format($cart->sum_price,0)}}</span>
                                                @endif
                                            </span>تومان
                                    </div>
                                    <a href="{{route('order.payment')}}" id="submit-button" class="selenium-next-step-shipping">
                                        <div class="parent-btn">
                                            <button class="dk-btn dk-btn-danger">
                                                ادامه ثبت سفارش
                                                <i class="now-ui-icons shopping_cart-simple"></i>
                                            </button>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>
    <!-- main-shopping -->

@endsection
