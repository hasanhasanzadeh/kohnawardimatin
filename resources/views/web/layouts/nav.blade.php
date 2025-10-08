<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm rtl-navbar" style="z-index: 1050; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{url('/')}}">
            @if($setting->logo_id)
                <img src="{{$setting->logo->address}}" height="35" alt="{{$setting->title}}" class="ml-2 rtl-logo">
            @endif
            <span class="text-danger font-weight-bold rtl-text" style="font-size: 1.2rem;">{{$setting->title}}</span>
        </a>

        <!-- Desktop Search Bar -->
        <div class="d-none d-lg-flex flex-grow-1 mx-4 rtl-search-container">
            <form action="{{url('/products/search')}}" class="w-100">
                <div class="input-group" >
                    <input type="search" name="title" value="{{request('title')??''}}"
                           class="form-control rtl-search-input"
                           placeholder="کالا مورد نظر خود را جستجو کنید…"
                           style="border-radius: 0 25px 25px 0; direction: rtl; text-align: right;border:2px solid #dc3545;">
                    <div class="input-group-append">
                        <button class="btn btn-danger rtl-search-btn" type="submit" style="border-radius: 25px 0 0 25px;top:-5px">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Desktop Action Buttons -->
        <div class="d-none d-lg-flex align-items-center rtl-actions">
            <a href="{{url('/cart')}}" class="btn btn-danger position-relative mx-2 rtl-btn"
               title="سبد خرید">
                <i class="fa fa-shopping-cart"></i>
                @if($cart && $cart->quantity > 0)
                    <span class="badge badge-danger position-absolute rtl-badge"
                          style="top: -8px; left: -8px; font-size: 0.7rem;">
                        {{$cart->quantity}}
                    </span>
                @endif
            </a>
            <a href="{{url('/user/profile')}}" class="btn btn-primary mx-2 rtl-btn"
               title="پروفایل کاربر">
                <i class="fa fa-user"></i>
            </a>
        </div>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 d-lg-none rtl-toggle" type="button" data-toggle="collapse"
                data-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false"
                aria-label="Toggle navigation" style="outline: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <!-- Mobile Menu Overlay -->
    <div class="collapse navbar-collapse d-lg-none" id="mobileMenu">
        <div class="mobile-menu-overlay rtl-mobile-overlay">
            <!-- Mobile Header -->
            <div class="mobile-header d-flex justify-content-between align-items-center p-3 border-bottom rtl-mobile-header">
                <a href="{{url('/')}}" class="navbar-brand text-danger font-weight-bold rtl-mobile-brand">
                    @if($setting->logo_id)
                        <img src="{{$setting->logo->address}}" height="30" alt="{{$setting->title}}" class="ml-2 rtl-mobile-logo">
                    @endif
                    <span class="rtl-text">{{$setting->title}}</span>
                </a>
                <button class="btn btn-link text-dark rtl-close-btn" data-toggle="collapse" data-target="#mobileMenu">
                    <i class="fa fa-times fa-lg"></i>
                </button>
            </div>

            <!-- Mobile Search -->
            <div class="mobile-search p-3 border-bottom rtl-mobile-search">
                <form action="{{url('/products/search')}}" dir="ltr">
                    <div class="input-group rtl-mobile-input-group">
                        <input type="search" name="title" value="{{request('title')??''}}"
                               class="form-control rtl-mobile-search-input"
                               placeholder="جستجو در محصولات..."
                               style="direction: ltr; text-align: right;">
                        <div class="input-group-append">
                            <button class="btn btn-danger rtl-mobile-search-btn" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Mobile Action Buttons -->
            <div class="mobile-actions p-3 border-bottom rtl-mobile-actions">
                <div class="row text-center rtl-mobile-buttons">
                    <div class="col-6">
                        <a href="{{url('/cart')}}" class="btn btn-danger btn-block position-relative rtl-mobile-btn">
                            <i class="fa fa-shopping-cart ml-2"></i>
                            <span class="rtl-text">سبد خرید</span>
                            @if($cart && $cart->quantity > 0)
                                <span class="badge badge-danger position-absolute rtl-mobile-badge"
                                      style="top: -5px; left: -5px;">
                                    {{$cart->quantity}}
                                </span>
                            @endif
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{url('/user/profile')}}" class="btn btn-primary btn-block rtl-mobile-btn">
                            <i class="fa fa-user ml-2"></i>
                            <span class="rtl-text">پروفایل</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div class="mobile-navigation rtl-mobile-navigation">
                <ul class="navbar-nav rtl-navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link mobile-nav-link rtl-mobile-nav-link" href="{{url('/')}}">
                            <i class="fa fa-home ml-3"></i>
                            <span class="rtl-text">خانه</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mobile-nav-link rtl-mobile-nav-link" href="{{url('/cats/all')}}">
                            <i class="fa fa-th-large ml-3"></i>
                            <span class="rtl-text">همه دسته ها</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        @if(count($category->childrenRecursive) > 0)
                            <li class="nav-item">
                                <a class="nav-link mobile-nav-link rtl-mobile-nav-link d-flex justify-content-between align-items-center"
                                   data-toggle="collapse" data-target="#submenu-{{$category->id}}"
                                   aria-expanded="false" aria-controls="submenu-{{$category->id}}">
                                    <span class="rtl-submenu-text">
                                        <i class="fa fa-folder ml-3"></i>
                                        <span class="rtl-text">{{$category->name}}</span>
                                    </span>
                                    <i class="fa fa-chevron-down submenu-arrow rtl-submenu-arrow"></i>
                                </a>
                                <div class="collapse submenu rtl-submenu" id="submenu-{{$category->id}}">
                                    <div class="submenu-content rtl-submenu-content">
                                        <a class="submenu-item rtl-submenu-item" href="{{url('/category/show/'.$category->slug)}}">
                                            <i class="fa fa-arrow-right ml-2"></i>
                                            <span class="rtl-text">{{$category->name}}</span>
                                        </a>
                                        @include('web.partials.category_dropdown_mobile', ['categories'=>$category->childrenRecursive])
                                    </div>
                                </div>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link mobile-nav-link rtl-mobile-nav-link" href="{{url('/category/show/'.$category->slug)}}">
                                    <i class="fa fa-tag ml-3"></i>
                                    <span class="rtl-text">{{$category->name}}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</nav>
