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
    <main class="profile-user-page">
        <div class="container">
            <div class="row">
                <div class="profile-page col-xl-9 col-lg-8 col-md-12 order-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-12">
                                <h1 class="title-tab-content">اطلاعات شخصی</h1>
                            </div>
                            <div class="content-section default">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">نام و نام خانوادگی :</span>
                                            <span>{{$user->full_name}}</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">پست الکترونیک :</span>
                                            @if($user->email)
                                                <span>{{$user->email}}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">شماره تلفن همراه:</span>
                                            <span>{{$user->mobile}}</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">کد ملی :</span>
                                            @if($user->national_code)
                                                <span>{{$user->national_code}}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">دریافت خبرنامه :</span>
                                            @if($user->news_letter)
                                                <span>بله</span>
                                            @else
                                                <span>خیر</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">جنسیت :</span>
                                            @if($user->gender=='male')
                                                <span>مرد</span>
                                            @elseif($user->gender=='female')
                                                <span>زن</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <p>
                                            <span class="title">شماره کارت :</span>
                                            @if($user->card_number)
                                                <span>{{$user->card_number}}</span>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-12 text-center">
                                        <a href="{{url('/users/profile/edit')}}" class="btn-link-border form-account-link">
                                            ویرایش اطلاعات شخصی
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="profile-page-aside col-xl-3 col-lg-4 col-md-6 center-section order-1">
                    <div class="profile-box">
                        <div class="profile-box-header">
                            <div class="profile-box-avatar">
                                @if($user->photo)
                                    <img src="{{$user->photo->address}}" alt="">
                                @else
                                    <img src="{{asset('assets/img/svg/user.svg')}}" alt="">
                                @endif
                            </div>
                            <button data-toggle="modal" data-target="#myModal" class="profile-box-btn-edit">
                                <i class="fa fa-pen"></i>
                            </button>
                            <!-- Modal Core -->
                            <div class="modal-share modal-width-custom modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">تغییر نمایه کاربری شما</h4>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="profile-avatars default text-center">
                                                @if($user->photo)
                                                    <li>
                                                        <img src="{{$user->photo->address}}" class="profile-avatars-item" alt="">
                                                    </li>
                                                @else
                                                    <li>
                                                        <img src="{{asset('assets/img/svg/user.svg')}}" class="profile-avatars-item" alt="">
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Core -->
                        </div>
                        <div class="profile-box-username">
                            {{$user->name}}
                            <hr>
                            <h5>
                                {{number_format($user->wallet,0)}} تومان
                            </h5>
                            <i class="fa fa-wallet"></i>
                            <span>موجودی کیف پول شما</span>
                        </div>
                        <div class="profile-box-tabs">
{{--                            <a href="{{url('/password/change')}}" class="profile-box-tab profile-box-tab-access">--}}
{{--                                <i class="now-ui-icons ui-1_lock-circle-open"></i>--}}
{{--                                تغییر رمز--}}
{{--                            </a>--}}
                            <a href="{{route('logout')}}" class="p-2 profile-box-tab--sign-out">
                                <i class="now-ui-icons media-1_button-power"></i>
                                خروج از حساب
                            </a>
                        </div>
                    </div>
                    <div class="responsive-profile-menu show-md">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-navicon"></i>
                                حساب کاربری شما
                            </button>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a href="{{url('/user/profile')}}" class="dropdown-item">
                                    <i class="now-ui-icons users_single-02"></i>
                                    پروفایل
                                </a>
                                @if(!$user->roles->isEmpty())
                                    <a href="{{url('/panel')}}" class="dropdown-item ">
                                        <i class="fas fa-tachometer-alt"></i>
                                        پنل سایت
                                    </a>
                                @endif
                                <a href="{{url('/user/wallet')}}" class="dropdown-item">
                                    <i class="fa fa-wallet"></i>
                                    کیف پول
                                </a>
                                <a href="{{url('/profile/orders')}}" class="dropdown-item">
                                    <i class="now-ui-icons shopping_cart-simple"></i>
                                    همه سفارش ها
                                </a>
                                <a href="{{url('/profile/likes')}}" class="dropdown-item">
                                    <i class="now-ui-icons ui-2_favourite-28"></i>
                                    لیست علاقمندی ها
                                </a>
                                <a href="{{url('/user/profile/show')}}" class="dropdown-item active-menu">
                                    <i class="now-ui-icons business_badge"></i>
                                    اطلاعات شخصی
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="profile-menu hidden-md">
                        <div class="profile-menu-header">حساب کاربری شما</div>
                        <ul class="profile-menu-items">
                            <li>
                                <a href="{{url('/user/profile')}}" >
                                    <i class="now-ui-icons users_single-02"></i>
                                    پروفایل
                                </a>
                            </li>
                            @if(!$user->roles->isEmpty())
                            <li>
                                <a href="{{url('/panel/admin')}}" >
                                    <i class="fas fa-tachometer-alt"></i>
                                    پنل سایت
                                </a>
                            </li>
                            @endif
                            <li>
                                <a href="{{url('/user/wallet')}}" >
                                    <i class="fa fa-wallet"></i>
                                    کیف پول
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/profile/orders')}}">
                                    <i class="now-ui-icons shopping_cart-simple"></i>
                                    همه سفارش ها
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/profile/likes')}}">
                                    <i class="now-ui-icons ui-2_favourite-28"></i>
                                    لیست علاقمندی ها
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/user/profile/show')}}" class="active">
                                    <i class="now-ui-icons business_badge"></i>
                                    اطلاعات شخصی
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- main -->

@endsection
