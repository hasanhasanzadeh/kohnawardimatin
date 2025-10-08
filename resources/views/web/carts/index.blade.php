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
    @if( count($cart_products) )
            <!-- main -->
            <main class="cart-page default margin-top">
                <div class="container mt-8">
                    <div class="row">
                        <div class="cart-page-content col-xl-9 col-lg-8 col-md-12 order-0">
                            <div class="cart-page-title">
                                <h1>سبد خرید</h1>
                            </div>
                            <div class="table-responsive checkout-content default">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light text-center">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>عکس محصول</th>
                                        <th>نام محصول</th>
                                        <th>ویژگی‌ها و تعداد</th>
                                        <th>تعداد</th>
                                        <th>قیمت واحد</th>
                                        <th>قیمت کل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $rang = 0 ?>
                                    @foreach($cart_products as $cart_product)
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="d-block mb-2">{{ ++$rang }}</span>
                                                <form action="{{ route('cart.destroy', $cart_product->product_id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">حذف</button>
                                                </form>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ url('/product/show/' . $cart_product->product->slug) }}">
                                                    <img src="{{ $cart_product->product->photo->address }}" alt="{{ $cart_product->product->title }}" class="img-fluid" style="max-height: 100px;">
                                                </a>
                                            </td>
                                            <td class="align-middle text-center">
                                                <h6 class="mb-0">{{ $cart_product->product->title }}</h6>
                                            </td>
                                            <td class="align-middle text-right" dir="rtl">
                                                @if($cart_product->option)
                                                    @php $attributes = json_decode($cart_product->option, true); @endphp
                                                    <form action="{{ route('cart.changed') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $cart_product->product_id }}">
                                                        @foreach($attributes as $key => $attribute)
                                                            <div class="mb-2">
                                                                <div class="mb-1">
                                                                    @foreach($attribute['value_id'] as $value)
                                                                        @php $attr = App\Models\AttributeValue::find($value); @endphp
                                                                        <span class="badge badge-secondary mr-1">
                                                    {{ $attr->attribute->name ?? '-' }}: {{ $attr->value ?? '-' }}
                                                </span>
                                                                    @endforeach
                                                                    <input type="hidden" name="value_id[]" value="{{ implode(',', $attribute['value_id']) }}">
                                                                </div>
                                                                <div class="form-group mb-0">
                                                                    <select name="quantity[{{ $key }}]" class="form-control form-control-sm" onchange="this.form.submit();">
                                                                        @for($i = 1; $i <= $cart_product->product->quantity; $i++)
                                                                            <option value="{{ $i }}" @if($i == $attribute['quantity']) selected @endif>{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </form>
                                                @else
                                                    <form action="{{ route('cart.change') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $cart_product->product->id }}">
                                                        <div class="form-group mb-0">
                                                            <select name="quantity" class="form-control form-control-sm" onchange="this.form.submit();">
                                                                @for($i = 1; $i <= $cart_product->product->quantity; $i++)
                                                                    <option value="{{ $i }}" @if($i == $cart_product->qty) selected @endif>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">{{ $cart_product->qty }}</td>
                                            <td class="align-middle text-center">{{ number_format($cart_product->price, 0) }} تومان</td>
                                            <td class="align-middle text-center">{{ number_format($cart_product->price * $cart_product->qty, 0) }} تومان</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <aside class="cart-page-aside col-xl-3 col-lg-4 col-md-6 center-section order-0">
                            <div class="checkout-aside">
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
                                            <a href="{{url('/checkouts')}}" class="selenium-next-step-shipping">
                                                <div class="parent-btn">
                                                    <button class="dk-btn dk-btn-danger">
                                                        ادامه ثبت سفارش
                                                        <i class="now-ui-icons shopping_cart-simple"></i>
                                                    </button>
                                                </div>
                                            </a>
                                            <div>
                                                <span>
                                                    کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش مراحل بعدی
                                                    را تکمیل
                                                    کنید.
                                                </span>
                                                <span class="wiki wiki-holder"><span class="wiki-sign"></span>
                                                    <div class="wiki-container is-right">
                                                        <div class="wiki-arrow"></div>
                                                        <p class="wiki-text">
                                                            محصولات موجود در سبد خرید شما تنها در صورت ثبت و پرداخت سفارش
                                                            برای شما رزرو
                                                            می‌شوند. در
                                                            صورت عدم ثبت سفارش، {{$setting->title}} هیچگونه مسئولیتی در قبال تغییر
                                                            قیمت یا موجودی
                                                            این کالاها
                                                            ندارد.
                                                        </p>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </main>
            <!-- main -->
        @else
            <!-- main -->
            <main class="cart default">
                <div class="container text-center">
                    <div class="cart-empty">
                        <div class="cart-empty-icon">
                            <i class="now-ui-icons shopping_cart-simple"></i>
                        </div>
                        <div class="cart-empty-title">سبد خرید شما خالیست!</div>
                        @if(auth()->check())
                            <div class="parent-btn">
                                <a href="{{url('/')}}" class="dk-btn dk-btn-danger">
                                    بازگشت به صفحه اصلی
                                    <i class="fa fa-home"></i>
                                </a>
                            </div>
                        @else
                            <div class="parent-btn">
                                <a href="{{route('login')}}" class="dk-btn dk-btn-danger">
                                    به حساب کاربری خود وارد شوید
                                    <i class="fa fa-sign-in-alt"></i>
                                </a>
                            </div>
                            <div class="cart-empty-url">
                                <span>کاربر جدید هستید؟</span>
                                <a href="{{route('login')}}" class="text-danger">ثبت‌نام در {{$setting->title}}</a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="container">
                    @if(!$products->isEmpty())
                    <div class="row">
                        <div class="col-12">
                            <div class="widget widget-product card">
                                <header class="card-header">
                                    <h3 class="card-title">
                                        <span>محصولات محبوب از دید مشتریان</span>
                                    </h3>
                                    <a href="{{url('/')}}" class="view-all">مشاهده همه</a>
                                </header>
                                <div class="product-carousel owl-carousel owl-theme">
                                    @foreach($products as $product)
                                    <div class="item">
                                        @if($product->discount > 0)
                                            <div class="label-check">{{$product->discount}} % -</div>
                                        @endif
                                        @if($product->quantity < 1 || $product->status=='soon')
                                            <div class="label-check mt-5"> ناموجود </div>
                                        @endif
                                        <a href="{{url('/product/show/'.$product->slug)}}">
                                            <img src="{{$product->photo->address}}"
                                                 class="img-fluid h-200" alt="">
                                        </a>
                                        <h2 class="post-title">
                                            <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}}</a>
                                        </h2>
                                        <div class="price">
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
                </div>
            </main>
            <!-- main -->
        @endif

@endsection
