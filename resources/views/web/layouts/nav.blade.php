<!-- responsive-header -->
<nav class="navbar direction-ltr  header-responsive   fixed-top shadow">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand text-danger font-weight-bolder" href="{{url('/')}}">
                @if($setting->logo_id)
                    <img src="{{$setting->logo->address}}" height="24px" alt="{{$setting->title}}">
                @else
                    {{$setting->title}}
                @endif

            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                    data-target="#navigation" aria-controls="navigation-index" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
            <div class="search-nav default text-right" >
                <ul class="col-2" style="margin:0;padding:0;">
                    <li class="flex justify-content-end">
                        <a title="سبد خرید" href="{{url('/cart')}}" class="font-bold fa-4x flex justify-between px-2" data-after-text="{{$cart?$cart->quantity:0}}" data-after-type="badge top right">
                            <span><i class="now-ui-icons shopping_cart-simple basket-ft-1 text-black"></i></span>
                        </a>
                        <a title="پروفایل کاربر" href="{{url('/user/profile')}}" class="font-bold fa-4x"><i class="now-ui-icons users_single-02"></i></a>
                    </li>
                </ul>
                <div class="col-10 float-right">
                    <form action="{{url('/products/search')}}" class="search">
                        <input type="search" name="title"  placeholder=" کالا مورد نظر خود را جستجو کنید…">
                        <button type="submit"><img src="{{asset('assets/img/search.png')}}" alt=""></button>
                    </form>
                </div>

            </div>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <div class="logo-nav-res default text-center">
                <a href="{{url('/')}}" class="text-danger font-weight-bolder">
                    @if($setting->logo_id)
                        <img src="{{$setting->logo->address}}" height="36px" alt="{{$setting->title}}">
                    @else
                        {{$setting->title}}
                    @endif
                </a>
            </div>
            <ul class="navbar-nav default">
                @foreach($categories as $category)
                    <li class="@if(count($category->childrenRecursive) > 0) sub-menu @endif" >
                        <a href="{{url('/category/show/'.$category->slug)}}">
                            {{$category->name}}
                        </a>
                        @if(count($category->childrenRecursive) > 0)
                            <ul>
                                <a href="{{url('/category/show/'.$category->slug)}}">
                                    {{$category->name}}
                                </a>
                                @include('web.partials.category_submenu', ['categories'=>$category->childrenRecursive, 'level'=>1])
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
<!-- responsive-header -->
