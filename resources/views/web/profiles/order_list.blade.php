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
    <main class="profile-user-page ">
        <div class="container">
            <div class="row">
                <div class="profile-page col-xl-9 col-lg-8 col-md-12 order-2">
                    <div class="row">
                        <div class="col-6">
                            <h1 class="title-tab-content"> سفارش {{$order->id}} </h1>
                            <h1 class="mr-auto title-tab-content p-2">
                                وضیعت :
                                <a href="{{route('order.print',$order->id)}}" class="btn btn-info">
                                    فاکتور سفارش
                                </a>
                            </h1>
                        </div>
                        <div class="content-section default">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <td>شناسه محصول</td>
                                                    <td>نام محصول</td>
                                                    <td>عکس محصول</td>
                                                    <td>تعداد</td>
                                                    <td>قیمت واحد</td>
                                                    <td>قیمت کل</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($order->products as $product)
                                                    <tr>
                                                        <td><a href="{{url('/product/show/'.$product->slug)}}" class="text-info">{{$product->sku}}</a></td>
                                                        <td><a href="{{url('/product/show/'.$product->slug)}}" class="text-info">{{$product->title}}</a></td><td>
                                                            <a href="{{url('/product/show/'.$product->slug)}}">
                                                                <img src="{{$product->photo->address}}" class="product-box-img" alt="">
                                                            </a>
                                                        </td>
                                                        <td>
                                                            @if($product->pivot->option!=null)
                                                                @php
                                                                    $attributes=json_decode($product->pivot->option,true);
                                                                @endphp
                                                                @foreach($attributes as $attribute)
                                                                    <div class="flex justify-content-between items-center">
                                                                        <div>
                                                                            @foreach($attribute['value_id'] as $value)
                                                                                <span class="pr-3">
                                                                                    <span>{{App\Models\AttributeValue::find($value)->attribute->name }} :</span>
                                                                                    <span>{{App\Models\AttributeValue::find($value)->value }}</span>
                                                                                </span>
                                                                            @endforeach
                                                                        </div>
                                                                        <div>
                                                                            {{$attribute['quantity']}}
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                                <span>{{$product->pivot->qty}}</span>
                                                            @endif
                                                            <h4>
                                                                {{$product->pivot->qty}}
                                                            </h4>
                                                        </td>
                                                        <td>
                                                            <div class="text-danger ft-16 p-2">
                                                                    {{number_format($product->pivot->price,0)}} تومان
                                                            </div>
                                                        </td>
                                                        <td>
                                                           {{number_format($product->pivot->qty*$product->pivot->price,0)}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td>گیرنده</td>
                                                    <td>شماره تماس گیرنده</td>
                                                    <td colspan="2">آدرس</td>
                                                    <td >هزینه پست</td>
                                                    <td>مبلغ پرداختی</td>
                                                </tr>
                                                <tr>
                                                    <td> {{$order->address->receptor_name}}</td>
                                                    <td> {{$order->address->receptor_mobile}} </td>
                                                    <td colspan="2">
                                                        {{$order->address->city->province->name}} - {{$order->address->city->name}} - {{$order->address->address_text}}
                                                    </td>
                                                    <td >
                                                        <span>
                                                        {{ number_format($order->post->price,0) .' تومان '}}
                                                        </span>

                                                        <span class="px-2 text-danger">
                                                             @if($order->post->payment_state)
                                                                پس کرایه
                                                            @else
                                                                پیش کرایه
                                                            @endif
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge @if($order->status==0) badge-warning @else badge-info @endif p-2" style="font-size: 20px !important;">
                                                            {{number_format($order->amount,0)}}
                                                            <span class="px-2">تومان</span>
                                                        </span>
                                                    </td>
                                                </tr>

{{--                                                @if($order->status==0 && \Carbon\Carbon::parse($order->created_at)->addHours(24) > \Carbon\Carbon::now())--}}
{{--                                                    <tr class="text-center">--}}
{{--                                                        <td colspan="6">--}}
{{--                                                            <form action="{{route('get.payment')}}" method="POST">--}}
{{--                                                                @csrf--}}
{{--                                                                <input type="hidden" name="order_id" value="{{$order->id}}">--}}
{{--                                                                <div class="parent-btn">--}}
{{--                                                                    <button class="dk-btn dk-btn-info">--}}
{{--                                                                        پرداخت مبلغ سفارش--}}
{{--                                                                        <i class="now-ui-icons shopping_cart-simple"></i>--}}
{{--                                                                    </button>--}}
{{--                                                                </div>--}}
{{--                                                            </form>--}}
{{--                                                        </td>--}}
{{--                                                    </tr>--}}
{{--                                                @endif--}}

                                                </tfoot>
                                            </table>
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
                            {{$user->full_name}}
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
                        <div  class="btn-group">
                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-navicon"></i>
                                حساب کاربری شما
                            </button>
                            <div class="dropdown-menu dropdown-menu-right text-right">
                                <a href="{{url('/user/profile')}}" class="dropdown-item ">
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
                                    <i  class="fa fa-wallet"></i>
                                    کیف پول
                                </a>
                                <a href="{{url('/profile/orders')}}" class="dropdown-item active-menu">
                                    <i class="now-ui-icons shopping_cart-simple"></i>
                                    همه سفارش ها
                                </a>
                                <a href="{{url('/profile/likes')}}" class="dropdown-item">
                                    <i  class="now-ui-icons ui-2_favourite-28"></i>
                                    لیست علاقمندی ها
                                </a>
                                <a href="{{url('/user/profile/show')}}" class="dropdown-item">
                                    <i class="now-ui-icons business_badge "></i>
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
                                    <a href="{{url('/panel')}}" >
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
                                <a href="{{url('/profile/orders')}}" class="active">
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
                                <a href="{{url('/user/profile/show')}}">
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
