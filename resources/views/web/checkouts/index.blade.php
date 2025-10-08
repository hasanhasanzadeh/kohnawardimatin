@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{asset('/css/select2.min.css')}}">
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
    @if(! empty($address))
        <div class="wrapper default shopping-page">
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
                                <li>
                                    <a href="{{route('checkouts.payment')}}">
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
    @endif

    <!-- main -->
    <main class="shopping-page cart-page default">
        <div class="container">
            <div class="row">
                @if(empty($address))
                    <div class="account-box checkout-page col-12 col-sm-6 col-md-8 col-lg-9 order-1">
                        <div class="cart-page-title">
                            <h1>مشخصات شما</h1>
                        </div>
                        <div class="account-box-content">
                            <form class="form-account" method="POST" action="{{route('addresses.store')}}">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-account-title">نام و نام خانوادگی</div>
                                        <div class="form-account-row">
                                            <input class="input-field text-right" name="full_name" type="text"
                                                   placeholder="نام و نام خانوادگی خود را وارد نمایید"
                                                   value="{{auth()->user()->full_name}}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-account-title">کد ملی</div>
                                        <div class="form-account-row">
                                            <input class="input-field text-right" type="text" maxlength="10"
                                                   name="national_code"
                                                   @if(auth()->user()->national_code) value="{{auth()->user()->national_code}}"
                                                   @else value="{{old('national_code')}}"
                                                   @endif placeholder="کد ملی خود را وارد نمایید">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="checkout-title text-right">افزودن آدرس جدید</div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-account-title">نام و نام خانوادگی تحویل گیرنده</div>
                                        <div class="form-account-row">
                                            <input class="input-field text-right" type="text" name="receptor_name"
                                                   value="{{old('receptor_name')?old('receptor_name'):auth()->user()->full_name}}"
                                                   placeholder="نام تحویل گیرنده را وارد نمایید">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-account-title">شماره موبایل</div>
                                        <div class="form-account-row">
                                            <input class="input-field text-right" maxlength="11" type="tel"
                                                   name="receptor_mobile"
                                                   value="{{old('receptor_phone')?old('receptor_phone'):auth()->user()->mobile}}"
                                                   placeholder=" شماره موبایل خود را وارد نمایید">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-account-title">شهر خود را انتخاب کنید</div>
                                        <div class="form-account-row">
                                            <select name="city_id" id="city_select" class="input-field text-right">
                                                <option value="">انتخاب کنید</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="form-account-title">کد پستی</div>
                                        <div class="form-account-row">
                                            <input class="input-field text-right" maxlength="10" name="post_code"
                                                   value="{{old('post_code')}}" type="text"
                                                   placeholder="کد پستی خود را وارد نمایید">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-account-title">آدرس پستی</div>
                                        <div class="form-account-row">
                                            <textarea class="input-field text-right" name="address" rows="2"
                                                      placeholder="آدرس خود را وارد نمایید">{{old('address')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 mx-auto">
                                    <div class="form-account-row form-account-submit">
                                        <div class="parent-btn">
                                            <button class="dk-btn dk-btn-danger">
                                                ثبت و ارسال
                                                <i class="fa fa-sign-in-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="cart-page-content col-12 col-sm-6 col-md-8 col-lg-9 order-1">
                        <div class="cart-page-title">
                            <h1>انتخاب آدرس تحویل و نحوه سفارش</h1>
                        </div>
                        <section class="page-content default">
                            <form method="post" action="{{route('post.insert')}}" id="shipping-data-form">
                                <div class="headline">
                                    <span>انتخاب نحوه ارسال</span>
                                </div>
                                <div class="checkout-invoice">
                                    <div class="checkout-invoice-headline">
                                        @if(count(\App\Helpers\Helper::posts()))
                                            <form action="{{route('post.selected')}}" method="POST" id="form-post">
                                                @foreach(\App\Helpers\Helper::posts() as $key=>$post)
                                                    <div class="flex justify-between">
                                                        <div
                                                            class="flex justify-items-center justify-start  my-auto">
                                                            <div class="flex justify-items-center">
                                                                <label class="checkbox-form checkbox-primary">
                                                                    @if($cart->post_id && $post->id==$cart->post_id)
                                                                        <input type="radio" name="post" checked="checked" id="post-{{$post->id}}">
                                                                    @else
                                                                        <input type="radio" name="post"
                                                                               @if($key==0 && !$cart->post_id)  checked="checked"
                                                                               @endif id="post-{{$post->id}}">
                                                                    @endif
                                                                </label>
                                                                <label
                                                                    for="post-{{$post->id}}"> {{$post->title}} </label>
                                                            </div>
                                                            <div>
                                                                <div class="text-danger mt-2 fa-sm">
                                                                    <span class="px-3 h6">هزینه ارسال :</span>
                                                                    {{number_format($post->price,0)}}
                                                                    <span class="h6">تومان</span>
                                                                </div>
                                                                <div class="flex text-center">
                                                                        <div>
                                                                            @if($post->payment_state)
                                                                                <h6 class="p-4">{{__('dashboard.so_rent')}}</h6>
                                                                            @else
                                                                                <h6 class="p-4">{{__('dashboard.advance_rent')}}</h6>
                                                                            @endif
                                                                        </div>
                                                                        <div>
                                                                            <p>{!!$post->description!!}</p>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-none d-md-block m-3">
                                                            <img src="{{$post->photo->address}}" height="70" width="70"
                                                                 class="rounded mx-auto" alt="">
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endforeach
                                            </form>
                                        @else
                                            <div class="flex justify-items-center justify-start">
                                                <div class="form-account-agree">
                                                    <label class="checkbox-form checkbox-primary">
                                                        <input type="radio" name="post" checked="checked" id="post-we">
                                                    </label>
                                                    <label for="post-we" class="mt-2">هزینه ارسال : <span
                                                            class="text-danger font-bold">رایگان</span></label>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            </form>
                            <div class="address-section">
                                <div class="checkout-contact">
                                    <div class="checkout-contact-content">
                                        <ul class="checkout-contact-items">
                                            <li class="checkout-contact-item">
                                                گیرنده:
                                                <span class="full-name">{{$address->receptor_name}}</span>
                                                <a class="checkout-contact-btn-edit"
                                                   href="{{route('address.edit',$address->id)}}">اصلاح این آدرس</a>
                                            </li>
                                            <li class="checkout-contact-item">
                                                <div class="checkout-contact-item checkout-contact-item-mobile">
                                                    شماره تماس:
                                                    <span class="mobile-phone">{{$address->receptor_mobile}}</span>
                                                </div>
                                                <div class="checkout-contact-item-message">
                                                    کد پستی:
                                                    <span class="post-code">{{$address->post_code}}</span>
                                                </div>
                                                <br>
                                                استان
                                                <span class="state">{{$address->city->province->name}}</span>
                                                ، ‌شهر
                                                <span class="city">{{$address->city->name}}</span>
                                                ،
                                                <span class="address-part">{{$address->address_text}}</span>
                                            </li>
                                        </ul>
                                        <div class="checkout-contact-badge">
                                            <i class="now-ui-icons ui-1_check"></i>
                                        </div>
                                    </div>
                                    <a class="checkout-contact-location" href="{{route('address.create')}}">افزودن آدرس
                                        ارسال</a>
                                </div>
                            </div>
                            <div class="headline">
                                <span>مرسوله ها</span>
                            </div>
                            <div class="checkout-pack">
                                <section class="products-compact">
                                    <div class="box">
                                        <div class="row">
                                            @foreach($cart->products as $product)
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                                                    <div class="product-box-container">
                                                        <div class="product-box product-box-compact">
                                                            <a class="product-box-img"
                                                               href="{{url('/product/show/'.$product->slug)}}">
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
                                </section>

                                <div class="row">
                                    <div class="checkout-time-table checkout-time-table-time">
                                        <span class="p-3 m-2"></span>
                                        <div>
                                            <div
                                                class="checkout-time-table-title-bar checkout-time-table-title-bar-city">
                                                بازه تحویل سفارش: زمان تقریبی تحویل از
                                                <span>{{verta()->instance(\Carbon\Carbon::now())->format('%d %B')}}</span>
                                                تا
                                                <span>{{verta()->instance(\Carbon\Carbon::now()->addDays(7))->format('%d %B')}}</span>
                                            </div>
                                            @if($cart->post_id)
                                                <ul class="checkout-time-table-subtitle-bar m-2">
                                                    <li>شیوه ارسال در {{$setting->title}} : <span
                                                            class="px-2">{{$cart->post->title}}</span></li>
                                                    <li>هزینه ارسال:
                                                        <span class="px-2">{{number_format($cart->post_price,0)}}</span>
                                                        <span>تومان</span>
                                                        <span>
                                                                @if($cart->post->payment_state)
                                                                <span class="px-2">{{__('dashboard.so_rent')}}</span>
                                                            @else
                                                                <span
                                                                    class="px-2">{{__('dashboard.advance_rent')}}</span>
                                                            @endif
                                                            </span>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                @endif
                <aside class="cart-page-aside col-12 col-sm-6 col-md-4 col-lg-3 center-section order-0 md:order-1">
                    <div class="shipping-data-form">
                        <div class="headline">
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
                                    <a href="{{route('checkouts.payment')}}" class="selenium-next-step-shipping">
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
    <!-- main -->

@endsection

@section('script')
    <script src="{{asset('/js/select2.min.js')}}"></script>
    <script type="text/javascript">
        $('#city_select').select2({
            placeholder: '{{__('dashboard.city')}}',
            ajax: {
                url: '{{route('cities.search.all')}}',
                dataType: 'json',
                delay: 220,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (data) {
                            return {
                                text: 'استان : ' + data.province_name + ' - شهرستان : ' + data.city_name,
                                id: data.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
        $(document).ready(function () {
            let form = $('#form-post');
            let radioInputs = $('input[type=radio][name=post]');
            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            radioInputs.on('change', function () {
                if (this.checked) {
                    let formData = this.id;
                    console.log(formData);
                    $.ajax({
                        url: '{{route('post.selected')}}',
                        method: 'POST',
                        data: {
                            'post_id': formData.replace('post-', '')
                        },
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        success: function (response) {
                            window.location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection
