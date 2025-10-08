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
                                <h1 class="title-tab-content">اطلاعات کیف پول</h1>
                            </div>
                            <div class="content-section default">
                                <div class="row">
                                    <div class="col-12">
                                        <p class="text-center">
                                            <h3 class="title">
                                            <i class="fa fa-wallet"></i>
                                            موجودی کیف پول شما
                                            </h3>
                                            <h5 class="text-center">{{number_format($user->wallet,0)}} تومان</h5>
                                        </p>
                                    </div>
                                    <div class="col-sm-12 col-md-8 m-auto">
                                        <form action="{{route('wallet.charge')}}" method="POST" class="form-account">
                                            @csrf
                                            <div class="flex justify-between">
                                                <label for="amount" class="form-account-title">مبلغ شارژ</label>
                                                <span class="wallet text-2xl"></span>
                                            </div>
                                            <div class="form-account-row">
                                                <input class="input-field" id="wallet" name="amount" value="{{old('amount')}}" type="text" placeholder="مبلغ شارژ کیف پول را وارد کنید">
                                            </div>
                                            <div class="col-12 text-center">
                                                <button class="btn btn-default btn-lg" type="submit">پرداخت</button>
                                                <a href="{{url('/user/profile')}}" class="btn btn-default btn-lg">انصراف</a>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <th>ردیف</th>
                                                    <th>مبلغ شارژ</th>
                                                    <th>شماره پیگیری</th>
                                                    <th>وضعیت</th>
                                                    <th>تاریخ و ساعت</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php $wal=1;?>
                                                @foreach($payments as $wallet)
                                                    <tr>
                                                        <td>{{$wal}}</td>
                                                        <td>{{number_format($wallet->amount,0).' تومان '}} </td>
                                                        <td>{{$wallet->RefID}} </td>
                                                        <td style="font-size: 20px !important;">
                                                            @if($wallet->status=='done')
                                                                <span class="badge badge-info">موفق</span>
                                                            @elseif($wallet->status=='undone')
                                                                <span class="badge badge-danger">ناموفق</span>
                                                            @else
                                                                <span class="badge badge-warning">معلق</span>
                                                            @endif
                                                        </td>
                                                        <td>{{verta()->instance($wallet->created_at)->format('%d %B %Y  -  H:i:s')}}</td>
                                                    </tr>
                                                    <?php $wal++; ?>
                                                @endforeach
                                                </tbody>
                                                <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-center">
                                                        <div class="text-center">
                                                            {{$payments->appends(Request::except('page'))->render('pagination::bootstrap-4')}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                        </div>
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
                                                        <img src="{{$user->photo->address}}" class="profile-avatars-item img-rounded rounded-circle" alt="">
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
                        <div class="btn-group">
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
                                <a href="{{url('/user/wallet')}}" class="dropdown-item active-menu">
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
                                <a href="{{url('/user/profile/show')}}" class="dropdown-item">
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
                                    <a href="{{url('/panel')}}" >
                                        <i class="fas fa-tachometer-alt"></i>
                                        پنل سایت
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a href="{{url('/user/wallet')}}" class="active">
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
                                <a href="{{url('/profile/person')}}">
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

@section('script')
    <script src="{{url('/js/numtopersian.min.js')}}"></script>
    <script>
        $('body').on('keyup', '#wallet', function() {
            let price=Num2persian($(this).val())+" {{__('dashboard.toman')}} ";
            $('.wallet').html(price);
        });

    </script>
@endsection


