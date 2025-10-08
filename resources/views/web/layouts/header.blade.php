<!-- header -->
<header class="main-header default sticky-top shadow" style="z-index:  10000000 !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 col-5">
                <div class="logo-area default">
                    <a href="{{url('/')}}" class="text-danger font-weight-bolder pt-2">
                        <img src="{{$setting->logo->address}}" alt="{{$setting->title}}" style="height:45px !important;width:150px !important;">
                    </a>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-8 col-7">
                {{--                <div class="ui-input ui-input--quick-search">--}}
                {{--                    <input type="text" class="ui-input-field ui-input-field--cleanable"--}}
                {{--                           placeholder=" محصول یا برند یا دسته مورد نظر را جستجو کنید...">--}}
                {{--                    <span class="ui-input-cleaner"></span>--}}
                {{--                </div>--}}
                <form method="get" action="/product/search/title?">
                    <div class="c-search ui-input ui-input--quick-search" >
                        <input type="search" name="key" id="searchin" placeholder="نام محصول یا برند یا دسته مورد نظر را جستجو کنید" class="js-search-input" autocom  plete="off" value="" >
                        <span class="ui-input-cleaner"></span>
                        <div class="c-search__results js-search-results col-lg-12" id="container2">
                            <ul id="list" >

                            </ul>
                        </div>
                    </div>
                </form>

                <!--                        <div class="search-area default">-->
                <!--                            -->
                <!--                            <form action="" class="search">-->
                <!--                                <input type="text" placeholder="نام کالا، برند و یا دسته مورد نظر خود را جستجو کنید…">-->
                <!--                                <button type="submit"><img src="assets/img/search.png" alt=""></button>-->
                <!--                            </form>-->
                <!--                        </div>-->
            </div>
            <div class="col-md-3 col-sm-6 ">
                <div class="c-header__btn-container" >
                    <div class="c-header__btn">
                        @if(auth()->check())
                            <a  class="c-header__btn-login" href="{{url('user/profile')}}">
                                <span class="now-ui-icons users_single-02 font-1"></span>
                                {{auth()->user()->full_name}}
                            </a>
                        @else
                            <a  class="c-header__btn-login" href="{{route('login')}}">
                                <span class="now-ui-icons users_single-02 font-1"></span>
                                ورود به حساب کاربری
                            </a>
                        @endif
                    </div>
                </div>

            </div>
            <div class="col-md-2 col-sm-6" >
                <div class="cart dropdown" onmouseover="showDropdown()" onmouseleave="removeShow()">
                    <a href="#" class="" data-toggle="dropdown" id="navbarDropdownMenuLink1">
                        <i class="now-ui-icons shopping_cart-simple basket-ft-1 text-black"></i>
                        <span class="c-header__btn-cart-counter--square c-header__btn-cart-counter" >
                             @if(!$cart)
                                {{$cart->quantity}}
                            @else
                                0
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink1">
                        <div class="basket-header">
                            <div class="basket-total">
                                <span>مبلغ قابل پرداخت:</span>
                                @if(!$cart)
                                    {{number_format($cart->sum_price)}}
                                @else
                                    <span>0</span>
                                @endif
                                <span> تومان</span>
                            </div>
                            <a href="{{url('/cart')}}" class="basket-link">
                                        <span class="text-info">
                                            مشاهده سبد خرید
                                        </span>
                                <div class="basket-arrow"></div>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <nav class="main-menu">
        <div class="container">
            <ul class="list float-right"  >
                @foreach($categories as $category)
                    <li class="list-item list-item-has-children mega-menu mega-menu-col-5"  >
                        <a class="nav-link" href="{{url('/category/show/'.$category->slug)}}">
                            {{$category->name}}
                        </a>
                        @if(count($category->childrenRecursive) > 0)
                            <ul class="sub-menu nav" style="height: 400px!important;">
                                @include('web.partials.category_list', ['categories'=>$category->childrenRecursive, 'level'=>1])
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
<!-- header -->
