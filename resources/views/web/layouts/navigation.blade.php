<!-- header -->
<header class="main-header default sticky-top shadow" style="z-index:1000 !important;">
    <div class="container">
        <div class="row flex justify-between">
            <div class="flex col-12 col-sm-6 col-md-9 col-lg-8">
                    <div class="logo-area default">
                        <a href="{{url('/')}}" class="text-danger font-weight-bolder pt-2">
                            @if($setting->logo_id)
                                <img src="{{$setting->logo->address}}" height="24px" alt="{{$setting->title}}">
                            @else
                                {{$setting->title}}
                            @endif
                        </a>
                    </div>
                <div class="search-area default">
                    <form action="{{url('/products/search')}}" class="search">
                        <input type="search" name="title" value="{{request('title')??''}}"  placeholder=" کالا مورد نظر خود را جستجو کنید…">
                        <button type="submit"><img src="{{asset('assets/img/search.png')}}" alt=""></button>
                    </form>
                </div>
            </div>
            <div class="flex col-12 col-sm-6 col-md-3 col-lg-4 justify-content-end">
               <div class="pt-2" >
                        <div class="btn-logins">
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
                <div class="mx-2" style="border: 0.1px solid silver !important;height: 30px;margin: auto"></div>
               <div class="flex mx-4">
                        <a href="{{url('/cart')}}" class="font-bold fa-2x pt-2"
                           data-after-text="{{$cart?$cart->quantity:0}}"
                           data-after-type="badge top right">
                            <i class="now-ui-icons shopping_cart-simple basket-ft-1 text-black px-4"></i>
                        </a>
               </div>
            </div>
        </div>
    </div>
    <nav class="main-menu">
        <div class="container">
            <ul class="list float-right"  >
                <li class="list-item list-item-has-children mega-menu mega-menu-col-5" >
                    <a class="nav-link" href="{{url('/')}}">
                        خانه
                    </a>
                </li>
                <li class="list-item list-item-has-children mega-menu mega-menu-col-5" >
                    <a class="nav-link" href="{{url('cats/all')}}">
                        همه دسته ها
                    </a>
                </li>
                @foreach($categories as $category)
                    <li class="list-item list-item-has-children mega-menu mega-menu-col-5"  >
                        <a class="nav-link" href="{{url('/category/show/'.$category->slug)}}">
                            {{$category->name}}
                        </a>
                        @if(count($category->childrenRecursive) > 0)
                            <ul class="sub-menu nav" style="height: auto !important;width: 100% !important;">
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
