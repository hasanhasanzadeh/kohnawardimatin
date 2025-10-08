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
    <div class="wrapper default shopping-page" >
    <!-- header-shopping -->
    <header class="header-shopping default ">
        <div class="container ">
            <div class="row">
                <div class="col-12 text-center">
                    <ul class="checkout-steps">
                        <li>
                            <a  class="active">
                                <span>اطلاعات ارسال</span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="active">
                                <span>پرداخت</span>
                            </a>
                        </li>
                        <li class="active">
                            <a class="active">
                                <span>اتمام خرید و ارسال</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- header-shopping -->

    <!-- main-shopping -->
    <main class="cart-page default">
        <div class="container">
            <div class="row">
                <div class="cart-page-content col-12 order-1">
                    <section class="page-content default">
                        <div class="warning-checkout text-center default">
                            <div class="icon-warning">
                                <i class="fa fa-times"></i>
                            </div>
                            <h1>سفارش <a href="{{url('profile/orders/'.$order->id)}}">{{$order->id}}</a>با موفقیت در سیستم ثبت شد.اما پرداخت ناموفق بود.</h1>
                            <p class="text-warning">برای جلوگیری از لغو سیستمی سفارش،تا 24 ساعت آینده پرداخت را انجام دهید.</p>
                            <p>چنانچه طی این فرایند مبلغی از حساب شما کسر شده است،طی 72 ساعت آینده به حساب شما باز خواهد گشت.</p>
                        </div>
                        <div class="order-info default">
                            <h3>کد سفارش: <span>{{$order->id}}</span></h3>
                            <p>سفارش شما با موفقیت در سیستم ثبت شد و هم اکنون <span
                                    class="badge badge-warning">در انتظار پرداخت</span> است.جزئیات این سفارش را می توانید
                                با کلیک بر روی دکمه <a href="{{url('profile/orders/'.$order->id)}}" class="btn-link-border">پیگیری سفارش</a>مشاهده نمایید.</p>
                            <a href="{{url('profile/orders/'.$order->id)}}" class="btn-primary m-4">
                                پیگیری سفارش
                            </a>
                            <div class="table-responsive mt-5 mb-3">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">نام تحویل گیرنده : {{$address->receptor_name}}</th>
                                        <th scope="col">شماره تماس : {{$address->receptor_mobile}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">قیمت مرسوله : </th>
                                        <td>مبلغ کل : {{number_format($order->amount,0)}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">وضعیت پرداخت : پرداخت آنلاین(ناموفق)</th>
                                        <td>وضعیت سفارش: <span class="badge badge-danger ft-16">در انتظار پرداخت</span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">آدرس : {{$address->city->province->name}} - {{$address->city->name}} - {{$address->address_text}}</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
    <!-- main-shopping -->
    </div>
@endsection
