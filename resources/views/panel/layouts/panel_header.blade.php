<aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a target="_blank" class="mr-6 text-lg font-bold text-gray-800 dark:text-gray-200 flex flex-row justify-center items-center" href="{{$setting->url}}">
            @if($setting->logo_id)
                <img src="{{$setting->logo->address}}" width="130" height="130" class="mx-auto rounded-full" alt="{{$setting->title}}">
            @else
                <img src="{{url('/default-images/no-image.jpg')}}" width="150" height="90"  alt="{{$setting->title}}" class="rounded-full mx-auto">
            @endif
{{--            <span class="px-2 py-3">{{$setting->title}}</span>--}}
        </a>
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <span class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100" href="{{route('panel.index')}}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span class="ml-4 px-2">{{__('dashboard.dashboard')}}</span>
                </a>
            </li>
        </ul>
        <ul>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="customers-show" data-collapse-toggle="customers-show">
                <i class="fa-solid fa-users-gear"></i>
                <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>مشتری</span>
                <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="customers-show" class="hidden py-2 space-y-2">
                    @can('customer-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('customers.index')}}">
                                <i class="fas fa-users"></i>
                                <span class="ml-4 px-2">مشتری ها</span>
                            </a>
                        </li>
                    @endcan
                    @can('send-all')
                            <li class="relative pr-2">
                                <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('sends.index')}}">
                                    <i class="fas fa-comment-sms"></i>
                                    <span class="ml-4 px-2">{{__('dashboard.orders_sms')}}</span>
                                </a>
                            </li>
                    @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="catalog-show" data-collapse-toggle="catalog-show">
                <i class="fa-solid fa-archive"></i>
                <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>کاتالوگ</span>
                <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="catalog-show" class="hidden py-2 space-y-2">
                    @can('product-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('products.index')}}">
                                <i class="fa-solid fa-bullhorn"></i>
                                <span class="ml-4 px-2">{{__('dashboard.products')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('brand-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('brands.index')}}">
                                <i class="fa-solid fa-tags"></i>
                                <span class="ml-4 px-2">{{__('dashboard.brands')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('category-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('categories.index')}}">
                                <i class="fa-solid fa-cube"></i>
                                <span class="ml-4 px-2">{{__('dashboard.categories')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('slider-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('sliders.index')}}">
                                <i class="fa-solid fa-sliders"></i>
                                <span class="ml-4 px-2">{{__('dashboard.sliders')}}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="orders-show" data-collapse-toggle="orders-show">
                    <i class="fa-solid fa-shopping-cart"></i>
                    <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>سفارشات</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="orders-show" class="hidden py-2 space-y-2">
                    @can('payment-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('payments.index')}}">
                                <i class="fa-solid fa-dollar-sign"></i>
                                <span class="ml-4 px-2">{{__('dashboard.payments')}}</span>
                            </a>
                        </li>
                    @endcan
                        @can('order-all')
                            <li class="relative pr-2">
                                <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('orders.index')}}">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span class="ml-4 px-2">{{__('dashboard.orders')}}</span>
                                </a>
                            </li>
                        @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="area-show" data-collapse-toggle="area-show">
                    <i class="fa-solid fa-earth-asia"></i>
                    <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>ناحیه ها</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="area-show" class="hidden py-2 space-y-2">
                    @can('country-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('countries.index')}}">
                                <i class="fa-solid fa-earth-asia"></i>
                                <span class="ml-4 px-2">{{__('dashboard.countries')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('province-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('provinces.index')}}">
                                <i class="fa-solid fa-tree-city"></i>
                                <span class="ml-4 px-2">{{__('dashboard.provinces')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('city-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('cities.index')}}">
                                <i class="fa-solid fa-city"></i>
                                <span class="ml-4 px-2">{{__('dashboard.cities')}}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="level-show" data-collapse-toggle="level-show">
                    <i class="fa-solid fa-user-lock"></i>
                    <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>دسترسی ها</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="level-show" class="hidden py-2 space-y-2">
                    @can('role-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('roles.index')}}">
                                <i class="fa-solid fa-user-check"></i>
                                <span class="ml-4 px-2">{{__('dashboard.roles')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('permission-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('permissions.index')}}">
                                <i class="fa-solid fa-list-check"></i>
                                <span class="ml-4 px-2">{{__('dashboard.permissions')}}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="page-show" data-collapse-toggle="page-show">
                    <i class="fa-solid fa-file-circle-plus"></i>
                    <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>صفحات</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="page-show" class="hidden py-2 space-y-2">
                    @can('page-cat-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('page_cats.index')}}">
                                <i class="fas fa-file-image"></i>
                                <span class="ml-4 px-2">{{__('dashboard.page_cats')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('page-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('pages.index')}}">
                                <i class="fas fa-file-image"></i>
                                <span class="ml-4 px-2">{{__('dashboard.pages')}}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="setting-show" data-collapse-toggle="setting-show">
                    <i class="fa-solid fa-cogs"></i>
                    <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>تنظیمات</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="setting-show" class="hidden py-2 space-y-2">
                    @can('base-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('bases.index')}}">
                                <i class="fa-solid fa-tower-observation"></i>
                                <span class="ml-4 px-2">{{__('dashboard.bases')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('question-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('questions.index')}}">
                                <i class="fas fa-question"></i>
                                <span class="ml-4 px-2">{{__('dashboard.questions')}}</span>
                            </a>
                        </li>
                    @endcan
                    @can('setting-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('settings.index')}}">
                                <i class="fas fa-cogs"></i>
                                <span class="ml-4 px-2">{{__('dashboard.settings')}}</span>
                            </a>
                        </li>
                    @endcan
                        @can('media-all')
                            <li class="relative pr-2">
                                <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('medias.index')}}">
                                    <i class="fa-brands fa-instagram"></i>
                                    <span class="ml-4 px-2">{{__('dashboard.medias')}}</span>
                                </a>
                            </li>
                        @endcan
                    @can('symbol-all')
                        <li class="relative pr-2">
                            <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('symbols.index')}}">
                                <i class="fa fa-helicopter-symbol"></i>
                                <span class="ml-4 px-2">{{__('dashboard.symbols')}}</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="relative px-4 py-2">
                <button type="button" class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700" aria-controls="comments-show" data-collapse-toggle="comments-show">
                    <i class="fa-solid fa-commenting"></i>
                    <span class="flex-1 mr-3 text-right whitespace-nowrap" sidebar-toggle-item>ارتباطات</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="comments-show" class="hidden py-2 space-y-2">
                    @can('comment-all')
                            <li class="relative pr-2">
                                <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('comments.index')}}">
                                    <i class="fa-solid fa-comments"></i>
                                    <span class="ml-4 px-2">{{__('dashboard.comments')}}</span>
                                </a>
                            </li>
                        @endcan
                    @can('contact-all')
                            <li class="relative pr-2">
                                <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pr-4" href="{{route('contacts.index')}}">
                                    <i class="fa-sharp fa-solid fa-address-card"></i>
                                    <span class="ml-4 px-2">{{__('dashboard.contacts')}}</span>
                                </a>
                            </li>
                        @endcan
                </ul>
            </li>
            @can('search-all')
                    <li class="relative px-4 py-2">
                        <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11" href="{{route('searches.index')}}">
                            <i class="fa-solid fa-search"></i>
                            <span class="ml-4 px-2">{{__('dashboard.search')}}</span>
                        </a>
                    </li>
                @endcan
            @can('article-all')
            <li class="relative px-4 py-2">
                <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11" href="{{route('articles.index')}}">
                    <i class="fas fa-archive"></i>
                    <span class="ml-4 px-2">{{__('dashboard.articles')}}</span>
                </a>
            </li>
                @endcan
            @can('coupon-all')
                <li class="relative px-4 py-2">
                    <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11" href="{{route('coupons.index')}}">
                        <i class="fa-solid fa-gift"></i>
                        <span class="ml-4 px-2">{{__('dashboard.coupons')}}</span>
                    </a>
                </li>
            @endcan
            @can('post-all')
                    <li class="relative px-4 py-2">
                        <a class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 pl-11" href="{{route('posts.index')}}">
                            <i class="fa-solid fa-truck"></i>
                            <span class="ml-4 px-2">{{__('dashboard.posts')}}</span>
                        </a>
                    </li>
                @endcan
        </ul>
    </div>
</aside>
