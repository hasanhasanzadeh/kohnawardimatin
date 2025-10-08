<!-- responsive-header -->
<nav class="navbar direction-ltr  header-responsive   fixed-top shadow">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand text-danger font-weight-bolder" href="{{url('/')}}">
                <img src="{{$setting->logo->address}}" height="24px" alt="{{$setting->title}}">
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
            <div class="search-nav default text-right" >
                <ul class="col-3" style="margin:0;padding:0;">
                    <li><a href="{{url('/user/profile')}}"><i class="now-ui-icons users_single-02"></i></a></li>
                    <li>
                        <a href="/cart" class="">
                            <i class="now-ui-icons shopping_cart-simple pb-3"></i>
                            <span class="c-header__btn-cart-counter--square c-header__btn-cart-counter" style="padding-top:-10px; margin-top:-10px;">
                               @if(!$cart)
                                    {{$cart->quantity}}
                                @else
                                    0
                                @endif
                            </span>
                        </a>
                    </li>
                </ul>
                <form action="{{url('/product/search/title?')}}" method="get">
                <div class="ui-input ui-input--quick-search col-9" style="margin:0;padding:0;" dir="rtl">
                    <input type="search" name="search" id="search" class="ui-input-field ui-input-field--cleanable" placeholder="نام محصول یا برند یا دسته مورد نظر را جستجو کنید" value="" autocomplete="off">
                    <span class="ui-input-cleaner"></span>
                    <div class="c-results col-12" id="containers">
                        <ul id="lists">

                        </ul>
                    </div>
                </div>
                </form>

            </div>
        </div>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <div class="logo-nav-res default text-center">
                <a href="{{url('/')}}" class="text-danger font-weight-bolder">
                    <img src="{{$setting->logo->address}}" height="36px" alt="{{$setting->title}}">
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
