<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    @if($setting->favicon_id)
        <link rel="apple-touch-icon" sizes="76x76" href="{{$setting->favicon_id?$setting->favicon->address:''}}">
        <link rel="icon" type="image/png" href="{{$setting->favicon_id?$setting->favicon->address:''}}">
    @endif
    <title>{{$title??env('app_env')}}</title>
    {!! SEOMeta::generate() !!}
    <!-- styles app css -->
    <link href="{{ url('/css/font.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('/css/all.min.css')}}"/>
    <!-- CSS Files -->
    <link href="{{url('assets/css/bootstrap.min.css')}}" rel="stylesheet"/>
    <link href="{{url('assets/css/now-ui-kit.css')}}" rel="stylesheet"/>
    <link href="{{url('assets/css/plugins/owl.carousel.css')}}" rel="stylesheet"/>
    <link href="{{url('assets/css/plugins/owl.theme.default.min.css')}}" rel="stylesheet"/>
    <link href="{{url('assets/css/main.css')}}" rel="stylesheet"/>
    <link href="{{url('/css/style.css')}}" rel="stylesheet"/>
    <script src="{{url('/js/sweet-alert.min.js')}}"></script>
    @yield('style')
</head>
<body class="index-page sidebar-collapse default" dir="rtl">
@include('sweetalert::alert')
@include('web.layouts.coupons')
<!-- responsive-header -->
@include('web.layouts.nav')
<!-- responsive-header -->
<div class="wrapper default">
    <!-- header -->
    @include('web.layouts.navigation')
    @include('web.layouts.coupon')
    <!-- header -->
    @yield('content')
    @include('web.layouts.footer')
</div>

@if($setting->text_chat)
    {!! $setting->text_chat !!}
@endif
<!--   Core JS Files   -->
<script src="{{url('assets/js/core/jquery.3.2.1.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/core/popper.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/core/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/bootstrap-switch.js')}}"></script>
<script src="{{url('assets/js/plugins/nouislider.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/bootstrap-datepicker.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/jquery.sharrre.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/now-ui-kit.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/countdown.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/owl.carousel.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/jquery.easing.1.3.min.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/plugins/jquery.ez-plus.js')}}" type="text/javascript"></script>
<script src="{{url('assets/js/main.js')}}" type="text/javascript"></script>
<script>
    $("#image").change(function (e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#image-select').attr('src', e.target.result);
                $('#image-select').removeClass('hidden');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('.dropdown-arrow').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            // Get the parent dropdown container
            var $dropdown = $(this).closest('.nav-item.dropdown');

            // Toggle the dropdown menu
            $dropdown.find('.dropdown-menu').toggleClass('show');
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.nav-item.dropdown').length) {
                $('.dropdown-menu.show').removeClass('show');
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // RTL Language Detection
        const isRTL = document.documentElement.dir === 'rtl' ||
            document.documentElement.lang === 'fa' ||
            document.documentElement.lang === 'ar' ||
            document.querySelector('.rtl-navbar') !== null;

        // Mobile menu toggle with RTL support
        const mobileMenuToggle = document.querySelector('[data-target="#mobileMenu"]');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileMenuOverlay = document.querySelector('.mobile-menu-overlay');

        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', function() {
                mobileMenuOverlay.classList.toggle('show');
                document.body.style.overflow = mobileMenuOverlay.classList.contains('show') ? 'hidden' : '';

                // RTL-specific animations
                if (isRTL) {
                    const navLinks = document.querySelectorAll('.rtl-mobile-nav-link');
                    navLinks.forEach((link, index) => {
                        link.style.animationDelay = `${index * 0.1}s`;
                        link.style.animation = 'slideInLeft 0.3s ease forwards';
                    });
                }
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                    mobileMenuOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // RTL-specific close button
            const closeBtn = document.querySelector('.rtl-close-btn');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    mobileMenuOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                });
            }
        }

        // RTL Submenu toggle animations
        const submenuToggles = document.querySelectorAll('[data-toggle="collapse"]');
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const target = document.querySelector(this.getAttribute('data-target'));
                const arrow = this.querySelector('.submenu-arrow, .rtl-submenu-arrow');

                if (target) {
                    target.addEventListener('shown.bs.collapse', function() {
                        if (arrow) {
                            arrow.style.transform = 'rotate(180deg)';
                            arrow.style.transition = 'transform 0.3s ease';
                        }
                    });

                    target.addEventListener('hidden.bs.collapse', function() {
                        if (arrow) {
                            arrow.style.transform = 'rotate(0deg)';
                            arrow.style.transition = 'transform 0.3s ease';
                        }
                    });
                }
            });
        });

        // RTL Search functionality
        const searchInputs = document.querySelectorAll('.rtl-search-input, .rtl-mobile-search-input');
        searchInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.direction = 'rtl';
                this.style.textAlign = 'right';
            });
        });

        // RTL Keyboard navigation
        const rtlNavLinks = document.querySelectorAll('.rtl-mobile-nav-link');
        rtlNavLinks.forEach((link, index) => {
            link.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowDown' && index < rtlNavLinks.length - 1) {
                    e.preventDefault();
                    rtlNavLinks[index + 1].focus();
                } else if (e.key === 'ArrowUp' && index > 0) {
                    e.preventDefault();
                    rtlNavLinks[index - 1].focus();
                }
            });
        });

        // RTL Smooth scroll for anchor links
        const anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // High Class Loading and Management
        function loadHighClass() {
            // Ensure high class styles are loaded
            const highStyle = document.createElement('style');
            highStyle.id = 'high-class-styles';
            highStyle.textContent = `
                .high {
                    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%) !important;
                    color: #ffffff !important;
                    box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3) !important;
                    transform: translateY(-2px) !important;
                    transition: all 0.3s ease !important;
                }
                .high:hover {
                    background: linear-gradient(135deg, #ee5a24 0%, #d63031 100%) !important;
                    transform: translateY(-3px) !important;
                    box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4) !important;
                }
                .high.rtl-btn {
                    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%) !important;
                    color: #ffffff !important;
                    border: none !important;
                }
                .high.rtl-mobile-nav-link {
                    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%) !important;
                    color: #ffffff !important;
                    border-left: 4px solid #ffffff !important;
                    border-right: none !important;
                }
                .high.rtl-submenu-item {
                    background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%) !important;
                    color: #ffffff !important;
                    border-left: 3px solid #ffffff !important;
                    border-right: none !important;
                }
            `;

            // Remove existing high class styles if any
            const existingStyle = document.getElementById('high-class-styles');
            if (existingStyle) {
                existingStyle.remove();
            }

            // Add the high class styles
            document.head.appendChild(highStyle);

            // Apply high class to elements that should be highlighted
            const elementsToHighlight = document.querySelectorAll('[data-high="true"]');
            elementsToHighlight.forEach(element => {
                element.classList.add('high');
            });
        }

        // Load high class immediately
        loadHighClass();

        // RTL Performance optimization
        if (isRTL) {
            // Preload RTL fonts
            const fontLink = document.createElement('link');
            fontLink.rel = 'preload';
            fontLink.href = 'https://fonts.googleapis.com/css2?family=Tahoma:wght@400;600;700&display=swap';
            fontLink.as = 'style';
            document.head.appendChild(fontLink);

            // RTL-specific performance optimizations
            const rtlElements = document.querySelectorAll('.rtl-text, .rtl-mobile-nav-link, .rtl-submenu-item');
            rtlElements.forEach(element => {
                element.style.willChange = 'transform, opacity';
            });
        }

        // High Class Utility Functions
        function addHighClass(element) {
            if (element && !element.classList.contains('high')) {
                element.classList.add('high');
                element.style.animation = 'fadeIn 0.3s ease forwards';
            }
        }

        function removeHighClass(element) {
            if (element && element.classList.contains('high')) {
                element.classList.remove('high');
                element.style.animation = 'fadeOut 0.3s ease forwards';
            }
        }

        function toggleHighClass(element) {
            if (element) {
                if (element.classList.contains('high')) {
                    removeHighClass(element);
                } else {
                    addHighClass(element);
                }
            }
        }

        // Add fade animations for high class
        const fadeStyle = document.createElement('style');
        fadeStyle.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(10px); }
            }
        `;
        document.head.appendChild(fadeStyle);

        // Ensure high class loads on page load
        window.addEventListener('load', function() {
            loadHighClass();

            // Add high class to active navigation items
            const activeNavItems = document.querySelectorAll('.nav-link.active, .rtl-mobile-nav-link.active');
            activeNavItems.forEach(item => {
                addHighClass(item);
            });
        });

        // Fix Menu Visibility Issues
        function fixMenuVisibility() {
            // Force navbar to be visible
            const navbar = document.querySelector('.rtl-navbar');
            if (navbar) {
                navbar.style.display = 'block';
                navbar.style.visibility = 'visible';
            }

            // Force mobile menu overlay to be visible when shown
            const mobileOverlay = document.querySelector('.mobile-menu-overlay');
            if (mobileOverlay) {
                if (mobileOverlay.classList.contains('show')) {
                    mobileOverlay.style.display = 'block';
                    mobileOverlay.style.visibility = 'visible';
                    mobileOverlay.style.transform = 'translateX(0)';
                }
            }

            // Force mobile navigation to be visible
            const mobileNav = document.querySelector('.mobile-navigation');
            if (mobileNav) {
                mobileNav.style.display = 'block';
                mobileNav.style.visibility = 'visible';
            }

            // Force navbar collapse to be visible
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse) {
                navbarCollapse.style.display = 'block';
                navbarCollapse.style.visibility = 'visible';
            }
        }

        // Run fix on load and resize
        window.addEventListener('load', fixMenuVisibility);
        window.addEventListener('resize', fixMenuVisibility);

        // Run fix periodically to ensure menu stays visible
        setInterval(fixMenuVisibility, 1000);

        // RTL Accessibility enhancements
        if (isRTL) {
            // Add RTL-specific ARIA labels
            const rtlButtons = document.querySelectorAll('.rtl-btn, .rtl-mobile-btn');
            rtlButtons.forEach(button => {
                if (!button.getAttribute('aria-label')) {
                    button.setAttribute('aria-label', button.textContent.trim());
                }
            });

            // RTL focus management
            const rtlFocusableElements = document.querySelectorAll('.rtl-mobile-nav-link, .rtl-search-input, .rtl-mobile-search-input');
            rtlFocusableElements.forEach(element => {
                element.addEventListener('focus', function() {
                    this.style.outline = '2px solid #dc3545';
                    this.style.outlineOffset = '2px';
                });

                element.addEventListener('blur', function() {
                    this.style.outline = 'none';
                });
            });
        }

        // Export high class functions to global scope for external use
        window.highClassUtils = {
            add: addHighClass,
            remove: removeHighClass,
            toggle: toggleHighClass,
            load: loadHighClass
        };
    });
</script>
@yield('script')
</body>
</html>
