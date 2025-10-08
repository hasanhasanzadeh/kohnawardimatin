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
    <style>
        /* RTL Base Styles */
        .rtl-navbar {
            direction: rtl;
            text-align: right;
        }

        .rtl-text {
            direction: rtl;
            text-align: right;
            font-family: 'iran-yekan' !important;
        }

        .rtl-logo, .rtl-mobile-logo {
            margin-left: 8px;
            margin-right: 0;
        }

        /* Enhanced Background Gradients */
        .rtl-navbar {
            background: linear-gradient(135deg, #b6b3b3 0%, #f8f9fa 50%, #e9ecef 100%) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* RTL Search Container */
        .rtl-search-container {
            direction: rtl;
        }

        .rtl-input-group {
            direction: rtl;
        }

        .rtl-search-input {
            direction: rtl;
            text-align: right;
            border-radius: 0 25px 25px 0 !important;
            background: linear-gradient(135deg, #edeaea 0%, #f8f9fa 100%);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .rtl-mobile-search-input::placeholder,.rtl-search-input::placeholder{
            color: #353333;
        }

        .rtl-search-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            background: #ffffff;
        }

        .rtl-search-btn {
            border-radius: 25px 0 0 25px !important;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .rtl-search-btn:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        /* RTL Action Buttons */
        .rtl-actions {
            direction: rtl;
        }

        .rtl-btn {
            border-radius: 25px;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, transparent 0%, rgba(255,255,255,0.1) 100%);
        }

        .rtl-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .rtl-badge {
            left: -8px !important;
            right: auto !important;
            color:white!important;
        }

        /* Mobile Menu Overlay with RTL Support */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            z-index: 1040;
            overflow-y: auto;
            transform: translateX(100%);
            transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            direction: rtl;
        }

        .mobile-menu-overlay.show {
            transform: translateX(0);
        }

        .rtl-mobile-overlay {
            direction: rtl;
            text-align: right;
        }

        /* Mobile Header with RTL Support */
        .mobile-header {
            background: linear-gradient(135deg, #c0c4c6 0%, #e9ecef 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            direction: rtl;
        }

        .rtl-mobile-header {
            direction: rtl;
            text-align: right;
        }

        .rtl-mobile-brand {
            direction: rtl;
            text-align: right;
        }

        .rtl-close-btn {
            margin-left: 0;
            margin-right: auto;
        }

        /* Mobile Search with RTL Support */
        .mobile-search {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            direction: rtl;
        }

        .rtl-mobile-search {
            direction: ltr;
            text-align: right;
        }

        .rtl-mobile-input-group {
            direction: ltr;
        }

        .rtl-mobile-search-input {
            text-align: right;
            border-radius: 25px;
            border: 2px solid #dd222a;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            transition: all 0.3s ease;
        }

        .rtl-mobile-search-input:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            background: #ffffff;
        }

        .rtl-mobile-search-btn {
            top: -5px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .rtl-mobile-search-btn:hover {
            background: linear-gradient(135deg, #dfd3d3 0%, #bd2130 100%);
            transform: translateY(-1px);
        }

        /* Mobile Actions with RTL Support */
        .mobile-actions {
            background: linear-gradient(135deg, #047c7c 0%, #078f8f 100%);
            direction: rtl;
        }

        .rtl-mobile-actions {
            direction: rtl;
            text-align: right;
        }

        .rtl-mobile-buttons {
            direction: rtl;
        }

        .rtl-mobile-btn {
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, transparent 0%, rgba(16, 191, 236, 0.1) 100%);
            direction: rtl;
            text-align: right;
            color:black;
        }

        .rtl-mobile-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.2);
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.1) 100%);
        }

        .rtl-mobile-badge {
            left: -5px !important;
            right: auto !important;
        }

        /* Mobile Navigation with RTL Support */
        .mobile-navigation {
            background: linear-gradient(135deg, #403e3e 0%, #979ca1 100%);
            direction: rtl;
        }

        .rtl-mobile-navigation {
            direction: rtl;
            text-align: right;
        }

        .rtl-navbar-nav {
            direction: rtl;

        }

        .mobile-nav-link {
            padding: 15px 20px;
            color: #1e1e1e;
            font-weight: 500;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            direction: rtl;
            text-align: right;
        }

        .rtl-mobile-nav-link {
            direction: rtl;
            text-align: right;
            padding: 15px 20px 15px 40px;
            color:black;
        }

        .rtl-mobile-nav-link:hover {
            background: linear-gradient(270deg, #3f4145 0%, #575a5c 100%);
            color: #dc3545;
            padding-left: 30px;
            padding-right: 20px;
        }

        .rtl-mobile-nav-link i {
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
            margin-left: 12px;
            margin-right: 0;
            color:black;
        }

        .rtl-mobile-nav-link:hover i {
            transform: scale(1.1);
        }

        .rtl-submenu-text {
            direction: rtl;
            text-align: right;
        }

        .rtl-submenu-arrow {
            margin-left: 0;
            margin-right: auto;
            transition: transform 0.3s ease;
        }

        /* Submenu Styles with RTL Support */
        .submenu {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-left: 3px solid #dc3545;
            border-right: none;
            direction: rtl;
        }

        .rtl-submenu {
            direction: rtl;
            text-align: right;
            border-left: 3px solid #dc3545;
            border-right: none;
        }

        .submenu-content {
            padding: 10px 0;
            direction: rtl;
        }

        .rtl-submenu-content {
            direction: rtl;
            text-align: right;
        }

        .submenu-item {
            display: block;
            padding: 12px 40px 12px 20px;
            color: #666;
            text-decoration: none;
            transition: all 0.3s ease;
            border-bottom: 1px solid #e9ecef;
            direction: rtl;
            text-align: right;
        }

        .rtl-submenu-item {
            direction: rtl;
            text-align: right;
            padding: 12px 40px 12px 20px;
        }

        .rtl-submenu-item:hover {
            background: linear-gradient(270deg, #ffffff 0%, #f8f9fa 100%);
            color: #dc3545;
            padding-left: 50px;
            padding-right: 40px;
            text-decoration: none;
        }

        .submenu-arrow {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .mobile-nav-link[aria-expanded="true"] .submenu-arrow {
            transform: rotate(180deg);
        }

        .rtl-submenu-arrow {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
        }

        .rtl-mobile-nav-link[aria-expanded="true"] .rtl-submenu-arrow {
            transform: rotate(180deg);
        }

        /* Professional RTL Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .mobile-nav-link {
            animation: slideInLeft 0.3s ease forwards;
        }

        .rtl-mobile-nav-link {
            animation: slideInLeft 0.3s ease forwards;
        }

        .mobile-nav-link:nth-child(1) { animation-delay: 0.1s; }
        .mobile-nav-link:nth-child(2) { animation-delay: 0.2s; }
        .mobile-nav-link:nth-child(3) { animation-delay: 0.3s; }
        .mobile-nav-link:nth-child(4) { animation-delay: 0.4s; }
        .mobile-nav-link:nth-child(5) { animation-delay: 0.5s; }

        .rtl-mobile-nav-link:nth-child(1) { animation-delay: 0.1s; }
        .rtl-mobile-nav-link:nth-child(2) { animation-delay: 0.2s; }
        .rtl-mobile-nav-link:nth-child(3) { animation-delay: 0.3s; }
        .rtl-mobile-nav-link:nth-child(4) { animation-delay: 0.4s; }
        .rtl-mobile-nav-link:nth-child(5) { animation-delay: 0.5s; }

        /* RTL Hover Effects */
        .mobile-nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(270deg, transparent, rgba(220, 53, 69, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .mobile-nav-link:hover::before {
            left: 100%;
        }

        .rtl-mobile-nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(270deg, transparent, rgba(220, 53, 69, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .rtl-mobile-nav-link:hover::before {
            left: 100%;
        }

        /* Enhanced Badge Styling with RTL Support */
        .badge {
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
            border-radius: 50px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .rtl-badge, .rtl-mobile-badge {
            left: -8px !important;
            right: auto !important;
        }

        /* Responsive Adjustments with RTL Support */
        @media (max-width: 576px) {
            .mobile-header, .rtl-mobile-header {
                padding: 15px;
                direction: rtl;
            }

            .mobile-search, .mobile-actions, .rtl-mobile-search, .rtl-mobile-actions {
                padding: 15px;
                direction: rtl;
            }

            .mobile-nav-link, .rtl-mobile-nav-link {
                padding: 12px 15px 12px 35px;
                font-size: 0.95rem;
                direction: rtl;
                text-align: right;
            }

            .submenu-item, .rtl-submenu-item {
                padding: 10px 15px 10px 35px;
                font-size: 0.9rem;
                direction: rtl;
                text-align: right;
            }

            .rtl-search-input, .rtl-mobile-search-input {
                font-size: 0.9rem;
            }
        }

        /* Smooth RTL Transitions */
        .navbar-collapse {
            transition: all 0.3s ease;
        }

        /* Professional RTL Button Styles */
        .btn {
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .rtl-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        /* Enhanced Custom Scrollbar for RTL Mobile Menu */
        .mobile-menu-overlay::-webkit-scrollbar {
            width: 6px;
        }

        .mobile-menu-overlay::-webkit-scrollbar-track {
            background: linear-gradient(135deg, #f1f1f1 0%, #e9ecef 100%);
        }

        .mobile-menu-overlay::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 3px;
        }

        .mobile-menu-overlay::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        }

        /* RTL Toggle Button */
        .rtl-toggle {
            margin-left: 0;
            margin-right: auto;
        }

        /* Advanced RTL Typography */
        .rtl-text {
            font-family: 'Tahoma', 'Arial', 'Segoe UI', sans-serif;
            line-height: 1.6;
            letter-spacing: 0.5px;
        }

        /* RTL Focus States */
        .rtl-search-input:focus,
        .rtl-mobile-search-input:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        /* RTL Loading States */
        .rtl-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        /* RTL Accessibility Improvements */
        .rtl-mobile-nav-link:focus {
            outline: 2px solid #dc3545;
            outline-offset: 2px;
        }

        /* High Class for Highlighting Elements - Enhanced Loading */
        .high,
        nav .high,
        .navbar .high,
        .mobile-menu-overlay .high {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%) !important;
            color: #ffffff !important;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3) !important;
            transform: translateY(-2px) !important;
            transition: all 0.3s ease !important;
            opacity: 1 !important;
            visibility: visible !important;
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

        /* RTL High Contrast Mode Support */
        @media (prefers-contrast: high) {
            .rtl-navbar {
                background: #ffffff !important;
                border-bottom: 2px solid #000000;
            }

            .rtl-text {
                color: #000000;
            }

            .rtl-mobile-nav-link {
                border-bottom: 1px solid #000000;
            }

            .high {
                background: #ff0000 !important;
                color: #ffffff !important;
                border: 2px solid #000000 !important;
            }
        }
    </style>
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
