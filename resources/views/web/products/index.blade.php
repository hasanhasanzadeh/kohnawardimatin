@extends('layouts.app')
@section('meta')
    {{-- Enhanced SEO Meta Tags --}}
    <title>{{$product->title}} - {{$setting->title}} | خرید آنلاین</title>
    <meta name="description" content="{{Str::limit(strip_tags($product->description), 160)}}">
    <meta name="keywords" content="{{$product->title}}, {{$product->brand->title ?? ''}}, {{implode(', ', $product->categories->pluck('name')->toArray())}}">
    <meta name="product_id" content="{{$product->id}}">
    <meta name="product_name" content="{{$product->title}}">
    <meta name="product_sku" content="{{$product->sku ?? $product->id}}">
    <meta name="product_category" content="{{$product->categories->first()->name ?? ''}}">
    <meta name="product_brand" content="{{$product->brand->title ?? ''}}">

    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="{{$product->title}} - {{$setting->title}}">
    <meta property="og:description" content="{{Str::limit(strip_tags($product->description), 200)}}">
    <meta property="og:image" content="{{$product->photo->address}}">
    <meta property="og:image:width" content="800">
    <meta property="og:image:height" content="600">
    <meta property="og:image:alt" content="{{$product->title}}">
    <meta property="og:type" content="product">
    <meta property="og:url" content="{{url('/product/show/'.$product->slug)}}">
    <meta property="og:site_name" content="{{$setting->title}}">
    <meta property="product:price:amount" content="{{$product->price}}">
    <meta property="product:price:currency" content="IRT">
    <meta property="product:availability" content="@if($product->quantity > 0) in stock @else out of stock @endif">
    <meta property="product:condition" content="new">
    <meta property="product:brand" content="{{$product->brand->title ?? ''}}">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$product->title}} - {{$setting->title}}">
    <meta name="twitter:description" content="{{Str::limit(strip_tags($product->description), 200)}}">
    <meta name="twitter:image" content="{{$product->photo->address}}">

    {{-- Additional Meta Tags --}}
    <meta name="product_price" content="{{number_format($product->price)}}">
    <meta name="product_old_price" content="{{number_format($product->original_price)}}">
    <meta name="availability" content="@if($product->quantity > 0) instock @else outofstock @endif">
    <meta name="guarantee" content="guarantee_sample">
    <meta name="robots" content="index, follow, max-image-preview:large">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    <link rel="canonical" href="{{url('/product/show/'.$product->slug)}}">

    {{-- Enhanced Structured Data --}}
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "name": "{{$product->title}}",
        "description": "{{strip_tags($product->description)}}",
        "image": [
            "{{$product->photo->address}}"
            @foreach($product->images as $image)
                ,"{{$image->address}}"
            @endforeach
        ],
        "sku": "{{$product->sku ?? $product->id}}",
        "mpn": "{{$product->sku ?? $product->id}}",
        "brand": {
            "@type": "Brand",
            "name": "{{$product->brand->title ?? $setting->title}}"
        },
        "category": "{{$product->categories->first()->name ?? 'General'}}",
        "offers": {
            "@type": "Offer",
            "price": "{{$product->price}}",
            "priceCurrency": "IRT",
            "availability": "https://schema.org/@if($product->quantity > 0)InStock @else OutOfStock @endif",
            "seller": {
                "@type": "Organization",
                "name": "{{$setting->title}}"
            },
            "priceValidUntil": "{{date('Y-m-d', strtotime('+1 year'))}}",
            @if($product->discount > 0)
            "priceSpecification": {
                "@type": "PriceSpecification",
                "price": "{{$product->price}}",
                "priceCurrency": "IRT"
            },
            @endif
            "shippingDetails": {
                "@type": "OfferShippingDetails",
                "shippingRate": {
                    "@type": "MonetaryAmount",
                    "value": "0",
                    "currency": "IRT"
                },
                "deliveryTime": {
                    "@type": "ShippingDeliveryTime",
                    "businessDays": {
                        "@type": "OpeningHoursSpecification",
                        "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]
                    }
                }
            }
        },
        @if($product->discount > 0)
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.5",
            "reviewCount": "{{count($product->comments)}}"
        },
        @endif
        "review": [
            @foreach($product->comments->take(3) as $index => $comment)
            {
                "@type": "Review",
                "author": {
                    "@type": "Person",
                    "name": "{{$comment->user->full_name ?? 'کاربر'}}"
                },
                "reviewBody": "{{strip_tags($comment->description)}}",
                "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "5"
                }
            }@if($index < 2),@endif
            @endforeach
        ]
    }
    </script>
    {{-- Advanced CSS with RTL Support and Modern Design --}}
    <style>
        :root {
            --primary-color: #dc3545;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --border-radius: 12px;
            --box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --font-family: 'Tahoma', 'Arial', 'Segoe UI', sans-serif;
        }

        /* RTL Base Styles */
        .rtl-product {
            direction: rtl;
            text-align: right;
            font-family: var(--font-family);
        }

        .rtl-text {
            direction: rtl;
            text-align: right;
        }

        /* Modern Product Gallery with CSS Grid */
        .product-gallery-container {
            position: relative;
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto auto;
            gap: 20px;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            overflow: hidden;
        }

        .main-image-container {
            position: relative;
            width: 100%;
            aspect-ratio: 4/3;
            border-radius: var(--border-radius);
            overflow: hidden;
            background: #f8f9fa;
            cursor: zoom-in;
            transition: var(--transition);
        }

        .main-image-container:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        }

        .product-main-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
            transition: var(--transition);
            border-radius: var(--border-radius);
        }

        .product-main-image.loading {
            opacity: 0.7;
            filter: blur(2px);
        }

        .product-main-image.loaded {
            opacity: 1;
            filter: none;
        }

        /* Enhanced Image Zoom Modal */
        .image-zoom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0,0,0,0.95);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
            cursor: zoom-out;
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-zoom-modal.show {
            display: flex;
            opacity: 1;
        }

        .image-zoom-content {
            position: relative;
            max-width: 95vw;
            max-height: 95vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-zoom-content img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: var(--border-radius);
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            transition: transform 0.3s ease;
        }

        .image-zoom-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255,255,255,0.1);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            font-size: 20px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .image-zoom-close:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.5);
            transform: scale(1.1);
        }

        /* Zoom Modal Navigation */
        .zoom-nav-arrows {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            transform: translateY(-50%);
            z-index: 10;
        }

        .zoom-nav-arrow {
            background: rgba(0,0,0,0.7);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .zoom-nav-arrow:hover:not(:disabled) {
            background: rgba(0,0,0,0.9);
            border-color: rgba(255,255,255,0.5);
            transform: scale(1.1);
        }

        .zoom-nav-arrow:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .zoom-counter {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            backdrop-filter: blur(10px);
        }

        .zoom-indicator {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .main-image-container:hover .zoom-indicator {
            opacity: 1;
        }

        .image-nav-arrows {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .main-image-container:hover .image-nav-arrows {
            opacity: 1;
        }

        .nav-arrow {
            background: rgba(0,0,0,0.7);
            border: none;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .nav-arrow:hover {
            background: rgba(0,0,0,0.9);
            transform: scale(1.1);
        }

        .nav-arrow:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        /* Modern Thumbnail Gallery with Touch Support */
        .gallery-thumbnails {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(80px, 1fr));
            gap: 12px;
            padding: 15px 0;
            overflow-x: auto;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) var(--light-color);
            scroll-behavior: smooth;
        }

        .gallery-thumbnails::-webkit-scrollbar {
            height: 6px;
        }

        .gallery-thumbnails::-webkit-scrollbar-track {
            background: var(--light-color);
            border-radius: 3px;
        }

        .gallery-thumbnails::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c82333 100%);
            border-radius: 3px;
        }

        .gallery-thumbnails::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
        }

        .gallery-thumbnail {
            position: relative;
            aspect-ratio: 1;
            border-radius: var(--border-radius);
            overflow: hidden;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-thumbnail::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(200, 35, 51, 0.1) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .gallery-thumbnail:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .gallery-thumbnail:hover::before {
            opacity: 1;
        }

        .gallery-thumbnail.active {
            border-color: var(--primary-color);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
        }

        .gallery-thumbnail.active::before {
            opacity: 1;
        }

        .gallery-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
            position: relative;
            z-index: 0;
        }

        .gallery-thumbnail:hover img {
            transform: scale(1.1);
        }

        .thumbnail-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0,0,0,0.7);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 2;
        }

        .gallery-thumbnail:hover .thumbnail-overlay {
            opacity: 1;
        }

        .image-counter {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .image-nav-hint {
            display: block;
            font-size: 12px;
            color: var(--secondary-color);
            margin-top: 5px;
            opacity: 0.7;
        }

        /* Loading Spinner */
        .image-loading-spinner {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(220, 53, 69, 0.1);
            border-left: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Error State */
        .product-main-image.error,
        .gallery-thumbnail img.error {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary-color);
            font-size: 14px;
        }

        .product-main-image.error::after,
        .gallery-thumbnail img.error::after {
            content: 'تصویر بارگذاری نشد';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        /* Product Information Section */
        .product-info-section {
            padding: 30px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin: 20px 0;
        }

        .product-title-container {
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            margin-bottom: 25px;
        }

        .product-title-main {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 10px;
            color: var(--dark-color);
            background: linear-gradient(135deg, var(--dark-color) 0%, var(--primary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-title-subtitle {
            font-size: 1.1rem;
            color: var(--secondary-color);
            font-weight: 400;
            font-style: italic;
        }

        /* Enhanced Price Section */
        .price-section {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px;
            border-radius: var(--border-radius);
            margin: 20px 0;
            border: 2px solid transparent;
            background-clip: padding-box;
            position: relative;
            overflow: hidden;
        }

        .price-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color) 0%, var(--success-color) 100%);
        }

        .price-current {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--success-color);
            text-shadow: 0 2px 4px rgba(40, 167, 69, 0.3);
        }

        .price-original {
            font-size: 1.3rem;
            color: var(--secondary-color);
            text-decoration: line-through;
            opacity: 0.8;
        }

        .discount-badge {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-right: 15px;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Advanced Product Actions */
        .product-actions {
            margin-top: 30px;
        }

        .btn-add-to-cart {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c82333 100%);
            border: none;
            color: white;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 25px;
            width: 100%;
            margin-top: 15px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.3);
        }

        .btn-add-to-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-add-to-cart:hover::before {
            left: 100%;
        }

        .btn-add-to-cart:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
        }

        .btn-add-to-cart:active {
            transform: translateY(0);
        }

        /* Enhanced Form Elements */
        .attribute-selector {
            margin: 15px 0;
        }

        .attribute-label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: var(--dark-color);
        }

        .attribute-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
            background: white;
        }

        .attribute-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
            outline: none;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 20px 0;
            padding: 15px;
            background: white;
            border-radius: var(--border-radius);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .quantity-label {
            font-weight: 600;
            color: var(--dark-color);
        }

        .quantity-select {
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            min-width: 100px;
            transition: var(--transition);
        }

        .quantity-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #e9ecef;
            background: white;
            color: var(--secondary-color);
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-btn:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: rgba(220, 53, 69, 0.1);
        }

        .quantity-input {
            width: 80px;
            text-align: center;
            padding: 10px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-weight: 600;
        }

        .quantity-input:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        .stock-info {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Wishlist and Share Buttons */
        .product-actions-buttons {
            display: flex;
            gap: 10px;
            margin: 20px 0;
        }

        .btn-wishlist, .btn-share, .btn-compare {
            flex: 1;
            padding: 12px;
            border: 2px solid #e9ecef;
            background: white;
            color: var(--secondary-color);
            border-radius: var(--border-radius);
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-wishlist:hover {
            border-color: var(--danger-color);
            color: var(--danger-color);
            background: rgba(220, 53, 69, 0.1);
        }

        .btn-share:hover {
            border-color: var(--info-color);
            color: var(--info-color);
            background: rgba(23, 162, 184, 0.1);
        }

        .btn-compare:hover {
            border-color: var(--warning-color);
            color: var(--warning-color);
            background: rgba(255, 193, 7, 0.1);
        }

        /* Enhanced Responsive Design */
        @media (max-width: 1200px) {
            .gallery-thumbnails {
                grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .product-title-main {
                font-size: 1.5rem;
            }

            .gallery-thumbnails {
                grid-template-columns: repeat(auto-fit, minmax(60px, 1fr));
                gap: 8px;
            }

            .main-image-container {
                aspect-ratio: 3/2;
            }

            .price-current {
                font-size: 1.8rem;
            }

            .gallery-thumbnail {
                min-width: 60px;
            }

            .image-nav-arrows {
                padding: 0 10px;
            }

            .nav-arrow {
                width: 40px;
                height: 40px;
                font-size: 16px;
            }

            .zoom-indicator {
                top: 10px;
                left: 10px;
                font-size: 12px;
                padding: 6px 12px;
            }
        }

        @media (max-width: 576px) {
            .product-gallery-container {
                padding: 15px;
                gap: 15px;
            }

            .product-info-section {
                padding: 20px 15px;
            }

            .quantity-selector {
                flex-direction: column;
                align-items: stretch;
            }

            .gallery-thumbnails {
                grid-template-columns: repeat(auto-fit, minmax(50px, 1fr));
                gap: 6px;
            }

            .main-image-container {
                aspect-ratio: 1/1;
            }

            .image-zoom-content {
                max-width: 98vw;
                max-height: 98vh;
            }

            .image-zoom-close {
                top: 10px;
                right: 10px;
                width: 40px;
                height: 40px;
                font-size: 16px;
            }
        }

        /* Touch Device Optimizations */
        @media (hover: none) and (pointer: coarse) {
            .gallery-thumbnail:hover {
                transform: none;
            }

            .gallery-thumbnail:hover::before {
                opacity: 0;
            }

            .gallery-thumbnail:hover .thumbnail-overlay {
                opacity: 0;
            }

            .main-image-container:hover {
                transform: none;
            }

            .main-image-container:hover .zoom-indicator {
                opacity: 0;
            }

            .main-image-container:hover .image-nav-arrows {
                opacity: 0;
            }

            .image-nav-arrows {
                opacity: 1;
            }

            .zoom-indicator {
                opacity: 1;
            }
        }

        /* Loading States */
        .loading {
            position: relative;
            overflow: hidden;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        /* Accessibility Improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus States */
        .btn-add-to-cart:focus,
        .attribute-select:focus,
        .quantity-select:focus,
        .gallery-thumbnail:focus,
        .main-image-container:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* Notification Styles */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            color: var(--dark-color);
            padding: 15px 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            z-index: 10001;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            max-width: 300px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification-success {
            border-left: 4px solid var(--success-color);
        }

        .notification-error {
            border-left: 4px solid var(--danger-color);
        }

        .notification-info {
            border-left: 4px solid var(--info-color);
        }

        /* RTL Notification Support */
        .rtl-notification {
            right: auto;
            left: 20px;
            transform: translateX(-100%);
        }

        .rtl-notification.show {
            transform: translateX(0);
        }
    </style>
@endsection

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
        $categories=$helper['categories'];
        $coupon=$helper['coupon'];
    @endphp

        <!-- Advanced Product Page with RTL Support -->
    <main class="single-product default rtl-product">
        <div class="container">
            {{-- Enhanced Breadcrumb with RTL Support --}}
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb" class="rtl-breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 rtl-breadcrumb-list">
                            <li class="breadcrumb-item">
                                <a href="{{url('/')}}" class="rtl-breadcrumb-link">
                                    <i class="fa fa-home ml-2"></i>
                                    فروشگاه اینترنتی {{$setting->title}}
                                </a>
                            </li>
                            @if($product->categories->isNotEmpty())
                                <li class="breadcrumb-item">
                                    <a href="{{url('/category/show/'.$product->categories->first()->slug)}}" class="rtl-breadcrumb-link">
                                        {{$product->categories->first()->name}}
                                    </a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active rtl-breadcrumb-active" aria-current="page">
                                <span class="text-truncate d-inline-block rtl-text" style="max-width: 300px;" title="{{$product->title}}">
                                    {{$product->title}}
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>

            {{-- Product Details --}}
            <div class="row">
                <div class="col-12">
                    <div class="product">
                        <div class="row">
                            {{-- Modern Product Gallery with Enhanced UX --}}
                            <div class="col-12 col-lg-6">
                                <div class="product-gallery-container rtl-gallery">
                                    {{-- Main Image Container with Enhanced Features --}}
                                    <div class="main-image-container"
                                         onclick="openImageZoom('{{$product->photo->address}}')"
                                         role="button"
                                         tabindex="0"
                                         aria-label="تصویر اصلی محصول - برای بزرگنمایی کلیک کنید">
                                        <img class="product-main-image"
                                             id="main-product-image"
                                             src="{{$product->photo->address}}"
                                             alt="{{$product->title}}"
                                             loading="lazy"
                                             data-zoom-src="{{$product->photo->address}}"
                                             onload="this.classList.add('loaded')"
                                             onerror="this.classList.add('error')">

                                        {{-- Image Zoom Indicator --}}
                                        <div class="zoom-indicator" aria-hidden="true">
                                            <i class="fa fa-search-plus" aria-hidden="true"></i>
                                            <span class="rtl-text">برای بزرگنمایی کلیک کنید</span>
                                        </div>

                                        {{-- Image Navigation Arrows --}}
                                        <div class="image-nav-arrows" aria-hidden="true">
                                            <button class="nav-arrow nav-arrow-prev"
                                                    onclick="previousImage()"
                                                    aria-label="تصویر قبلی"
                                                    disabled>
                                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                            </button>
                                            <button class="nav-arrow nav-arrow-next"
                                                    onclick="nextImage()"
                                                    aria-label="تصویر بعدی"
                                                    disabled>
                                                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                            </button>
                                        </div>

                                        {{-- Loading Spinner --}}
                                        <div class="image-loading-spinner" id="image-loading-spinner" style="display: none;">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>

                                    {{-- Enhanced Thumbnail Gallery with Touch Support --}}
                                    <div class="gallery-thumbnails"
                                         id="gallery-thumbnails"
                                         role="tablist"
                                         aria-label="گالری تصاویر محصول">
                                        <div class="gallery-thumbnail active"
                                             onclick="changeMainImage('{{$product->photo->address}}', this)"
                                             data-index="0"
                                             role="tab"
                                             aria-selected="true"
                                             aria-label="تصویر اصلی محصول"
                                             tabindex="0">
                                            <img src="{{$product->photo->address}}"
                                                 alt="{{$product->title}}"
                                                 loading="lazy"
                                                 onload="this.classList.add('loaded')"
                                                 onerror="this.classList.add('error')">
                                            <div class="thumbnail-overlay" aria-hidden="true">
                                                <i class="fa fa-eye"></i>
                                            </div>
                                        </div>
                                        @foreach($product->images as $key => $photo)
                                            <div class="gallery-thumbnail"
                                                 onclick="changeMainImage('{{$photo->address}}', this)"
                                                 data-index="{{$key + 1}}"
                                                 role="tab"
                                                 aria-selected="false"
                                                 aria-label="تصویر {{$key + 1}} محصول"
                                                 tabindex="0">
                                                <img src="{{$photo->address}}"
                                                     alt="{{$product->title}}"
                                                     loading="lazy"
                                                     onload="this.classList.add('loaded')"
                                                     onerror="this.classList.add('error')">
                                                <div class="thumbnail-overlay" aria-hidden="true">
                                                    <i class="fa fa-eye"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    {{-- Image Counter and Navigation Info --}}
                                    <div class="image-counter rtl-text" aria-live="polite">
                                        <span id="current-image">1</span> از <span id="total-images">{{count($product->images) + 1}}</span>
                                        <span class="image-nav-hint">(از کلیدهای جهت‌دار برای تغییر تصویر استفاده کنید)</span>
                                    </div>
                                </div>

                                {{-- Enhanced Gallery Actions --}}
                                <div class="product-actions-buttons rtl-actions">
                                    <form method="POST" action="{{route('like.add',$product->id)}}" class="d-inline flex-fill">
                                        @csrf
                                        <button type="submit" class="btn-wishlist rtl-btn" title="افزودن به علاقمندی" aria-label="افزودن به علاقمندی">
                                            <i class="fa fa-heart"></i>
                                            <span class="rtl-text">علاقمندی</span>
                                        </button>
                                    </form>
                                    <button class="btn-share rtl-btn" data-toggle="modal" data-target="#shareModal" title="اشتراک گذاری" aria-label="اشتراک گذاری">
                                        <i class="fa fa-share-alt"></i>
                                        <span class="rtl-text">اشتراک</span>
                                    </button>
                                    <button class="btn-compare rtl-btn" onclick="addToCompare({{$product->id}})" title="مقایسه" aria-label="افزودن به مقایسه">
                                        <i class="fa fa-balance-scale"></i>
                                        <span class="rtl-text">مقایسه</span>
                                    </button>
                                </div>
                            </div>

                            {{-- Advanced Product Information with RTL Support --}}
                            <div class="col-12 col-lg-6">
                                <div class="product-info-section rtl-product-info">
                                    {{-- Enhanced Product Title --}}
                                    <div class="product-title-container mb-4">
                                        <h1 class="product-title-main rtl-text">{{$product->title}}</h1>
                                        @if($product->original_name)
                                            <p class="product-title-subtitle rtl-text">{{$product->original_name}}</p>
                                        @endif

                                        {{-- Product Rating --}}
                                        <div class="product-rating mb-3">
                                            <div class="stars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star {{$i <= 4 ? 'text-warning' : 'text-muted'}}"></i>
                                                @endfor
                                            </div>
                                            <span class="rating-text rtl-text">({{count($product->comments)}} نظر)</span>
                                        </div>
                                    </div>

                                    {{-- Enhanced Product Directory --}}
                                    <div class="product-directory mb-4 rtl-directory">
                                        @if($product->brand_id)
                                            <div class="directory-item mb-3">
                                                <span class="directory-label rtl-text">برند:</span>
                                                <a href="{{url('/brand/'.$product->brand->slug)}}" class="directory-value rtl-text">
                                                    {{$product->brand->title}}
                                                </a>
                                            </div>
                                        @endif

                                        <div class="directory-item mb-3">
                                            <span class="directory-label rtl-text">دسته‌بندی:</span>
                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                @foreach($product->categories as $category)
                                                    <a href="{{url('/category/show/'.$category->slug)}}"
                                                       class="badge badge-primary rtl-badge">
                                                        <i class="fa fa-tag ml-1"></i>
                                                        {{$category->name}}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>

                                        @if($product->sku)
                                            <div class="directory-item mb-3">
                                                <span class="directory-label rtl-text">کد محصول:</span>
                                                <span class="directory-value rtl-text">{{$product->sku}}</span>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Enhanced Product Guarantee --}}
                                    <div class="guarantee-section mb-4">
                                        <div class="alert alert-success d-flex align-items-center rtl-alert">
                                            <i class="fa fa-shield-alt ml-3"></i>
                                            <div>
                                                <strong class="rtl-text">گارانتی اصالت و سلامت فیزیکی کالا</strong>
                                                <br>
                                                <small class="rtl-text">تضمین کیفیت و اصالت محصول</small>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Enhanced Seller Info --}}
                                    <div class="seller-info mb-4 rtl-seller">
                                        <div class="seller-card">
                                            <i class="fa fa-store ml-2"></i>
                                            <span class="rtl-text">فروشنده: <strong>{{$setting->title}}</strong></span>
                                        </div>
                                        <div class="seller-badges">
                                            <span class="badge badge-success rtl-badge">
                                                <i class="fa fa-check-circle ml-1"></i>
                                                تایید شده
                                            </span>
                                            <span class="badge badge-info rtl-badge">
                                                <i class="fa fa-shipping-fast ml-1"></i>
                                                ارسال سریع
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Enhanced Price Section with RTL Support --}}
                                    <div class="price-section rtl-price-section">
                                        <div class="price-header">
                                            <div class="price-current rtl-price">
                                                <span class="price-amount">{{number_format($product->price,0)}}</span>
                                                <span class="price-currency rtl-text">@lang('dashboard.toman')</span>
                                            </div>
                                            @if($product->discount > 0)
                                                <div class="discount-container">
                                                    <span class="discount-badge rtl-badge">
                                                        <i class="fa fa-percentage ml-1"></i>
                                                        {{$product->discount}}% تخفیف
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        @if($product->discount > 0)
                                            <div class="price-original rtl-original-price">
                                                <span class="original-amount">{{number_format($product->original_price,0)}}</span>
                                                <span class="original-currency rtl-text">@lang('dashboard.toman')</span>
                                            </div>
                                            <div class="savings-amount rtl-savings">
                                                <i class="fa fa-money-bill-wave ml-1"></i>
                                                <span class="rtl-text">صرفه‌جویی: {{number_format($product->original_price - $product->price,0)}} @lang('dashboard.toman')</span>
                                            </div>
                                        @endif

                                        {{-- Price Features --}}
                                        <div class="price-features rtl-features">
                                            <div class="feature-item">
                                                <i class="fa fa-truck ml-2"></i>
                                                <span class="rtl-text">ارسال سریع</span>
                                            </div>
                                            <div class="feature-item">
                                                <i class="fa fa-undo ml-2"></i>
                                                <span class="rtl-text">امکان بازگشت</span>
                                            </div>
                                            <div class="feature-item">
                                                <i class="fa fa-credit-card ml-2"></i>
                                                <span class="rtl-text">پرداخت امن</span>
                                            </div>
                                            <div class="feature-item">
                                                <i class="fa-solid fa-award ml-2"></i>
                                                <span class="rtl-text">تضمین اورجینال بودن کالا</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="product-add default">
                                        <div class="p-4">
                                            @if($product->status == 'active' && $product->quantity > 0 && $product->price != null)
                                                <form action="{{ route('cart.add') }}" method="post" class="form-account-row">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $product->id }}" />

                                                    {{-- Product Attributes --}}
                                                    <div class="form-group">
                                                        @foreach($attributes as $attribute)
                                                            <div class="form-row align-items-center mb-2">
                                                                <label for="attribute-{{ $attribute['attribute_id'] }}" class="col-auto col-form-label font-weight-bold">
                                                                    {{ $attribute['attribute_name'] }}:
                                                                </label>
                                                                <div class="col">
                                                                    <select class="form-control form-control-medium" name="value_id[]" id="attribute-{{ $attribute['attribute_id'] }}">
                                                                        @foreach(\App\Models\AttributeValue::whereIn('id', $attribute['values'])->get() as $value)
                                                                            <option value="{{ $value->id }}">{{ $value->value }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>

                                                    {{-- Quantity --}}
                                                    <div class="form-group">
                                                        <div class="form-row align-items-center mb-3">
                                                            <label for="quantity-select" class="col-auto col-form-label font-weight-bold">تعداد:</label>
                                                            <div class="col">
                                                                <select name="quantity" id="quantity-select" class="form-control form-control-sm">
                                                                    @for($i = 1; $i <= $product->quantity; $i++)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Submit Button --}}
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-danger btn-block">
                                                            افزودن به سبد خرید
                                                            <i class="now-ui-icons shopping_cart-simple"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @elseif($product->status == 'soon')
                                                <a href="#" class="btn btn-secondary btn-block">
                                                    به زودی
                                                    <i class="now-ui-icons empty-visible"></i>
                                                </a>
                                            @else
                                                <a href="#" class="btn btn-secondary btn-block">
                                                    ناموجود
                                                    <i class="now-ui-icons empty-visible"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>


                                    {{-- Product Text --}}
                                    <div class="my-2 p-4 mx-auto text-center">
                                    @if($setting->product_text)
                                            <?php
                                            header('Content-Type: text/html; charset=utf-8');

                                            $dom = new DOMDocument;
                                            libxml_use_internal_errors(true);

                                            // Force UTF-8 by wrapping in a meta tag
                                            $dom->loadHTML('<?xml encoding="UTF-8">' . $setting->product_text, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
                                            libxml_clear_errors();

                                            $links = $dom->getElementsByTagName('a');

                                            foreach ($links as $link) {
                                                $href = $link->getAttribute('href');
                                                $text = trim($link->nodeValue);

                                                echo '<a href="'.$href.'" target="_blank"><button class="btn btn-info rounded px-4 py-2" style="width:250px;">'.$text.'</button></a><br>';
}
                                            ?>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Product Tabs --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-0">
                            <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab">
                                        <i class="fa fa-file-text mr-2"></i>نقد و بررسی
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" id="specifications-tab" data-toggle="tab" href="#specifications" role="tab">
                                        <i class="fa fa-list mr-2"></i>مشخصات
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab">
                                        <i class="fa fa-comments mr-2"></i>نظرات ({{count($product->comments)}})
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="questions-tab" data-toggle="tab" href="#questions" role="tab">
                                        <i class="fa fa-question mr-2"></i>پرسش و پاسخ
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="productTabsContent">
                                {{-- Description Tab --}}
                                <div class="tab-pane fade" id="description" role="tabpanel">
                                    <article>
                                        <h3 class="mb-3">نقد و بررسی تخصصی {{$product->original_name}}</h3>
                                        <div class="content-area">
                                            {!! $product->description !!}
                                        </div>
                                    </article>
                                </div>

                                {{-- Specifications Tab --}}
                                <div class="tab-pane fade show active" id="specifications" role="tabpanel">
                                    <article>
                                        <h3 class="mb-3">مشخصات فنی {{$product->original_name}}</h3>
                                        <div class="specifications-content">
                                            {!! $product->attribute !!}
                                        </div>
                                    </article>
                                </div>

                                <div class="tab-pane fade" id="comments" role="tabpanel">
                                    <article>
                                        <h3 class="mb-3">نظرات کاربران</h3>
                                        @if(!$comments->isEmpty())
                                            <div class="comments-area">
                                                @include('layouts.comments',['commentable_id'=>$product->id,'subject'=>$product])
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <i class="fa fa-comment-slash fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">هیچ دیدگاه یا نظری ثبت یا تایید نشده است.</p>
                                            </div>
                                        @endif
                                    </article>
                                </div>

                                {{-- Questions Tab --}}
                                <div class="tab-pane fade" id="questions" role="tabpanel">
                                    <article>
                                        <h3 class="mb-3">افزودن نظر</h3>
                                        <form action="{{route('comment.store')}}" method="POST" class="comment-form">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="0">
                                            <input type="hidden" name="commentable_id" value="{{$product->id}}">
                                            <input type="hidden" name="commentable_type" value="{{get_class($product)}}">

                                            <div class="form-group">
                                                <label for="comment-text">نظر خود را بنویسید:</label>
                                                <textarea class="form-control"
                                                          id="comment-text"
                                                          name="description"
                                                          placeholder="نظر شما..."
                                                          rows="5"
                                                          required>{{old('description')}}</textarea>
                                            </div>

                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa fa-paper-plane mr-2"></i>
                                                ارسال نظر
                                            </button>
                                        </form>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @if(!$product_ms->isEmpty())
        <div class="row">
            <div class="col-12">
                <div class="widget widget-product card">
                    <header class="card-header">
                        <h3 class="card-title">
                            <span>محصولات مرتبط</span>
                        </h3>
                        <a href="{{url('/products/search?title=')}}" class="view-all">مشاهده همه </a>
                    </header>
                    <div class="product-carousel owl-carousel owl-theme">
                        @foreach($product_ms as $product)
                            <div class="item">
                                @if($product->discount > 0)
                                    <div class="label-check">{{$product->discount}} % -</div>
                                @endif
                                @if($product->quantity < 1 || $product->status=='soon')
                                    <div class="label-check mt-5"> ناموجود </div>
                                @endif
                                <a href="{{url('/product/show/'.$product->slug)}}">
                                    <img src="{{$product->photo->address}}"
                                         class="h-200 img-fluid" alt="{{$product->title}}">
                                </a>
                                <h2 class="post-title">
                                    <a href="{{url('/product/show/'.$product->slug)}}">{{$product->title}}</a>
                                </h2>
                                <div class="price">
                                    @if($product->discount >0)
                                        <div class="text-center">
                                            <del><span>{{number_format($product->original_price,0)}}<span>@lang('dashboard.toman')</span></span></del>
                                        </div>
                                    @endif
                                    <div class="text-center">
                                        <ins><span>{{number_format($product->price,0)}}<span>@lang('dashboard.toman')</span></span></ins>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Enhanced Image Zoom Modal with Touch Support --}}
    <div class="image-zoom-modal"
         id="imageZoomModal"
         onclick="closeImageZoom()"
         role="dialog"
         aria-modal="true"
         aria-labelledby="zoom-modal-title"
         aria-hidden="true">
        <div class="image-zoom-content" onclick="event.stopPropagation()">
            <img id="zoomedImage"
                 src=""
                 alt="تصویر بزرگ شده محصول"
                 onload="this.classList.add('loaded')"
                 onerror="this.classList.add('error')">

            <button class="image-zoom-close"
                    onclick="closeImageZoom()"
                    aria-label="بستن تصویر بزرگ شده"
                    title="بستن (ESC)">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>

            {{-- Zoom Modal Navigation --}}
            <div class="zoom-nav-arrows" aria-hidden="true">
                <button class="zoom-nav-arrow zoom-nav-prev"
                        onclick="previousImageInZoom()"
                        aria-label="تصویر قبلی"
                        disabled>
                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                </button>
                <button class="zoom-nav-arrow zoom-nav-next"
                        onclick="nextImageInZoom()"
                        aria-label="تصویر بعدی"
                        disabled>
                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                </button>
            </div>

            {{-- Zoom Modal Counter --}}
            <div class="zoom-counter" aria-live="polite">
                <span id="zoom-current-image">1</span> از <span id="zoom-total-images">1</span>
            </div>
        </div>
    </div>

    {{-- Enhanced Share Modal with RTL Support --}}
    <div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content text-right">
                <div class="modal-header flex justify-between">
                    <h5 class="modal-title ml-2" id="shareModalLabel">
                        <i class="fa fa-share-alt "></i>
                        اشتراک گذاری محصول
                    </h5>
                    <div class="flex items-end">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </div>

                {{-- Modal Body --}}
                <div class="modal-body">

                    {{-- Social Media Sharing --}}
                    <div class="text-center mb-4">
                        <h6>اشتراک گذاری در شبکه های اجتماعی</h6>
                        <div class="btn-group btn-group-toggle d-flex justify-content-center flex-wrap" dir="ltr" role="group">

                            <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->title) }}"
                               class="btn btn-info m-1" target="_blank">
                                <i class="fab fa-telegram"></i> تلگرام
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                               class="btn btn-primary m-1" target="_blank">
                                <i class="fab fa-facebook"></i> فیسبوک
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($product->title . ' - ' . request()->url()) }}"
                               class="btn btn-success m-1" target="_blank">
                                <i class="fab fa-whatsapp"></i> واتساپ
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($product->title) }}&url={{ urlencode(request()->url()) }}"
                               class="btn btn-info m-1" target="_blank">
                                <i class="fab fa-twitter"></i> توییتر
                            </a>
                        </div>
                    </div>

                    <hr>

                    {{-- URL Sharing --}}
                    <div class="form-group">
                        <label for="shareUrl">آدرس صفحه:</label>
                        <div class="input-group" dir="ltr">
                            <input type="text" class="form-control" id="shareUrl" value="{{ request()->url() }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" style="margin-top:0;" type="button" onclick="copyToClipboard()">
                                    <i class="fa fa-copy ml-1"></i> کپی
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Notify When Available Modal --}}
    <div class="modal fade" id="notifyModal" tabindex="-1" role="dialog" aria-labelledby="notifyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rtl-modal">
                <div class="modal-header rtl-header">
                    <h5 class="modal-title rtl-text" id="notifyModalLabel">
                        <i class="fa fa-bell ml-2"></i>
                        اطلاع‌رسانی هنگام موجود شدن
                    </h5>
                    <button type="button" class="close rtl-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body rtl-body">
                    <form id="notifyForm">
                        @csrf
                        <input type="hidden" id="notifyProductId" name="product_id">
                        <div class="form-group rtl-form-group">
                            <label for="notifyEmail" class="rtl-text">ایمیل شما:</label>
                            <input type="email" class="form-control rtl-input" id="notifyEmail" name="email" required>
                        </div>
                        <div class="form-group rtl-form-group">
                            <label for="notifyPhone" class="rtl-text">شماره موبایل (اختیاری):</label>
                            <input type="tel" class="form-control rtl-input" id="notifyPhone" name="phone">
                        </div>
                        <button type="submit" class="btn btn-primary rtl-btn btn-block">
                            <i class="fa fa-bell ml-2"></i>
                            <span class="rtl-text">ثبت درخواست</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
    <script>
        // Enhanced Product Page JavaScript with Modern Features

        // Global Variables
        let currentImageIndex = 0;
        let productImages = [];
        let isRTL = document.documentElement.dir === 'rtl' || document.querySelector('.rtl-product') !== null;
        let touchStartX = 0;
        let touchStartY = 0;
        let isZoomModalOpen = false;

        // Initialize Product Page
        document.addEventListener('DOMContentLoaded', function() {
            initializeProductPage();
            setupEventListeners();
            loadProductImages();
            initializeQRCode();
            setupTouchGestures();
            setupLazyLoading();
            preloadImages();
        });

        // Initialize Product Page
        function initializeProductPage() {
            // Set RTL direction
            if (isRTL) {
                document.body.classList.add('rtl-body');
            }

            // Initialize product images array
            const thumbnails = document.querySelectorAll('.gallery-thumbnail');
            productImages = Array.from(thumbnails).map(thumb => ({
                src: thumb.querySelector('img').src,
                index: parseInt(thumb.dataset.index)
            }));

            // Update image counter
            updateImageCounter();
            updateZoomCounter();
            updateNavigationButtons();
        }

        // Setup Event Listeners
        function setupEventListeners() {
            // Add to cart form
            const addToCartForm = document.getElementById('addToCartForm');
            if (addToCartForm) {
                addToCartForm.addEventListener('submit', handleAddToCart);
            }

            // Notify form
            const notifyForm = document.getElementById('notifyForm');
            if (notifyForm) {
                notifyForm.addEventListener('submit', handleNotifyRequest);
            }

            // Keyboard navigation
            document.addEventListener('keydown', handleKeyboardNavigation);

            // Image zoom modal
            const imageZoomModal = document.getElementById('imageZoomModal');
            if (imageZoomModal) {
                imageZoomModal.addEventListener('click', closeImageZoom);
            }
        }

        // Load Product Images
        function loadProductImages() {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            });
        }

        // Enhanced Gallery Image Switcher with Loading States
        function changeMainImage(imageSrc, thumbnail) {
            const mainImage = document.getElementById('main-product-image');
            const loadingSpinner = document.getElementById('image-loading-spinner');

            // Show loading state
            mainImage.classList.add('loading');
            if (loadingSpinner) loadingSpinner.style.display = 'block';

            // Update main image
            mainImage.src = imageSrc;
            mainImage.dataset.zoomSrc = imageSrc;

            // Remove active class from all thumbnails
            document.querySelectorAll('.gallery-thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
                thumb.setAttribute('aria-selected', 'false');
            });

            // Add active class to clicked thumbnail
            thumbnail.classList.add('active');
            thumbnail.setAttribute('aria-selected', 'true');

            // Update current image index
            currentImageIndex = parseInt(thumbnail.dataset.index);
            updateImageCounter();
            updateZoomCounter();
            updateNavigationButtons();

            // Preload adjacent images for better UX
            preloadAdjacentImages();

            // Remove loading state after image loads
            mainImage.addEventListener('load', function() {
                this.classList.remove('loading');
                this.classList.add('loaded');
                if (loadingSpinner) loadingSpinner.style.display = 'none';
            }, { once: true });

            // Handle image load error
            mainImage.addEventListener('error', function() {
                this.classList.remove('loading');
                this.classList.add('error');
                if (loadingSpinner) loadingSpinner.style.display = 'none';
            }, { once: true });
        }

        // Image Navigation with Enhanced UX
        function nextImage() {
            if (currentImageIndex < productImages.length - 1) {
                currentImageIndex++;
                const thumbnail = document.querySelector(`[data-index="${currentImageIndex}"]`);
                if (thumbnail) {
                    changeMainImage(productImages[currentImageIndex].src, thumbnail);
                    // Scroll thumbnail into view
                    thumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }
        }

        function previousImage() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                const thumbnail = document.querySelector(`[data-index="${currentImageIndex}"]`);
                if (thumbnail) {
                    changeMainImage(productImages[currentImageIndex].src, thumbnail);
                    // Scroll thumbnail into view
                    thumbnail.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }
        }

        // Update Image Counter
        function updateImageCounter() {
            const currentSpan = document.getElementById('current-image');
            const totalSpan = document.getElementById('total-images');
            if (currentSpan) currentSpan.textContent = currentImageIndex + 1;
            if (totalSpan) totalSpan.textContent = productImages.length;
        }

        // Update Zoom Counter
        function updateZoomCounter() {
            const currentSpan = document.getElementById('zoom-current-image');
            const totalSpan = document.getElementById('zoom-total-images');
            if (currentSpan) currentSpan.textContent = currentImageIndex + 1;
            if (totalSpan) totalSpan.textContent = productImages.length;
        }

        // Update Navigation Buttons State
        function updateNavigationButtons() {
            const prevBtn = document.querySelector('.nav-arrow-prev');
            const nextBtn = document.querySelector('.nav-arrow-next');
            const zoomPrevBtn = document.querySelector('.zoom-nav-prev');
            const zoomNextBtn = document.querySelector('.zoom-nav-next');

            if (prevBtn) prevBtn.disabled = currentImageIndex === 0;
            if (nextBtn) nextBtn.disabled = currentImageIndex === productImages.length - 1;
            if (zoomPrevBtn) zoomPrevBtn.disabled = currentImageIndex === 0;
            if (zoomNextBtn) zoomNextBtn.disabled = currentImageIndex === productImages.length - 1;
        }

        // Enhanced Image Zoom Functions
        function openImageZoom(imageSrc) {
            const modal = document.getElementById('imageZoomModal');
            const zoomedImage = document.getElementById('zoomedImage');

            if (!modal || !zoomedImage) return;

            zoomedImage.src = imageSrc;
            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            isZoomModalOpen = true;

            // Focus management for accessibility
            const closeBtn = modal.querySelector('.image-zoom-close');
            if (closeBtn) closeBtn.focus();

            // Update zoom counter
            updateZoomCounter();
            updateNavigationButtons();
        }

        function closeImageZoom() {
            const modal = document.getElementById('imageZoomModal');
            if (!modal) return;

            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
            isZoomModalOpen = false;

            // Return focus to main image
            const mainImage = document.getElementById('main-product-image');
            if (mainImage) mainImage.focus();
        }

        // Zoom Modal Navigation
        function nextImageInZoom() {
            if (isZoomModalOpen) {
                nextImage();
                const zoomedImage = document.getElementById('zoomedImage');
                if (zoomedImage) {
                    zoomedImage.src = productImages[currentImageIndex].src;
                }
            }
        }

        function previousImageInZoom() {
            if (isZoomModalOpen) {
                previousImage();
                const zoomedImage = document.getElementById('zoomedImage');
                if (zoomedImage) {
                    zoomedImage.src = productImages[currentImageIndex].src;
                }
            }
        }

        // Touch Gesture Support
        function setupTouchGestures() {
            const mainImageContainer = document.querySelector('.main-image-container');
            const galleryThumbnails = document.getElementById('gallery-thumbnails');

            if (mainImageContainer) {
                mainImageContainer.addEventListener('touchstart', handleTouchStart, { passive: true });
                mainImageContainer.addEventListener('touchend', handleTouchEnd, { passive: true });
            }

            if (galleryThumbnails) {
                galleryThumbnails.addEventListener('touchstart', handleThumbnailTouchStart, { passive: true });
                galleryThumbnails.addEventListener('touchend', handleThumbnailTouchEnd, { passive: true });
            }
        }

        function handleTouchStart(e) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }

        function handleTouchEnd(e) {
            if (!touchStartX || !touchStartY) return;

            const touchEndX = e.changedTouches[0].clientX;
            const touchEndY = e.changedTouches[0].clientY;
            const diffX = touchStartX - touchEndX;
            const diffY = touchStartY - touchEndY;

            // Only handle horizontal swipes
            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                if (diffX > 0) {
                    // Swipe left - next image
                    nextImage();
                } else {
                    // Swipe right - previous image
                    previousImage();
                }
            }

            touchStartX = 0;
            touchStartY = 0;
        }

        function handleThumbnailTouchStart(e) {
            touchStartX = e.touches[0].clientX;
        }

        function handleThumbnailTouchEnd(e) {
            if (!touchStartX) return;

            const touchEndX = e.changedTouches[0].clientX;
            const diffX = touchStartX - touchEndX;

            // Handle horizontal swipe on thumbnails
            if (Math.abs(diffX) > 50) {
                const galleryThumbnails = document.getElementById('gallery-thumbnails');
                if (galleryThumbnails) {
                    const scrollAmount = diffX > 0 ? 100 : -100;
                    galleryThumbnails.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                }
            }

            touchStartX = 0;
        }

        // Quantity Controls
        function increaseQuantity() {
            const quantityInput = document.getElementById('quantity-select');
            const maxQuantity = parseInt(quantityInput.max);
            const currentValue = parseInt(quantityInput.value);

            if (currentValue < maxQuantity) {
                quantityInput.value = currentValue + 1;
                updatePrice();
            }
        }

        function decreaseQuantity() {
            const quantityInput = document.getElementById('quantity-select');
            const currentValue = parseInt(quantityInput.value);

            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                updatePrice();
            }
        }

        // Update Price (if needed)
        function updatePrice() {
            // This function can be extended to update price based on selected attributes
            console.log('Price updated based on selections');
        }

        // Add to Cart Handler
        function handleAddToCart(e) {
            e.preventDefault();

            const form = e.target;
            const submitBtn = form.querySelector('.btn-add-to-cart');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoading = submitBtn.querySelector('.btn-loading');

            // Validate required attributes
            const attributeSelects = form.querySelectorAll('.attribute-select');
            let hasEmptyAttributes = false;

            attributeSelects.forEach(select => {
                if (select.value === '') {
                    hasEmptyAttributes = true;
                    select.style.borderColor = 'var(--danger-color)';
                } else {
                    select.style.borderColor = '#e9ecef';
                }
            });

            if (hasEmptyAttributes) {
                showNotification('لطفاً تمام ویژگی‌های محصول را انتخاب کنید', 'error');
                return;
            }

            // Show loading state
            btnText.style.display = 'none';
            btnLoading.style.display = 'block';
            submitBtn.disabled = true;

            // Submit form
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('محصول با موفقیت به سبد خرید اضافه شد', 'success');
                    updateCartCounter(data.cartCount);
                } else {
                    showNotification(data.message || 'خطا در افزودن محصول', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('خطا در ارتباط با سرور', 'error');
            })
            .finally(() => {
                // Reset button state
                btnText.style.display = 'block';
                btnLoading.style.display = 'none';
                submitBtn.disabled = false;
            });
        }

        // Buy Now Function
        function buyNow() {
            const form = document.getElementById('addToCartForm');
            if (form) {
                // Add hidden input for buy now
                const buyNowInput = document.createElement('input');
                buyNowInput.type = 'hidden';
                buyNowInput.name = 'buy_now';
                buyNowInput.value = '1';
                form.appendChild(buyNowInput);

                // Submit form
                form.submit();
            }
        }

        // Add to Compare
        function addToCompare(productId) {
            // Add to compare functionality
            showNotification('محصول به لیست مقایسه اضافه شد', 'success');
        }

        // Notify When Available
        function notifyWhenAvailable(productId) {
            document.getElementById('notifyProductId').value = productId;
            $('#notifyModal').modal('show');
        }

        // Handle Notify Request
        function handleNotifyRequest(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch('/notify-when-available', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('درخواست شما ثبت شد. هنگام موجود شدن اطلاع‌رسانی می‌شود', 'success');
                    $('#notifyModal').modal('hide');
                    form.reset();
                } else {
                    showNotification(data.message || 'خطا در ثبت درخواست', 'error');
                }
            })
            .catch(error => {
                showNotification('خطا در ارتباط با سرور', 'error');
            });
        }

        // Copy to Clipboard
        function copyToClipboard() {
            const shareUrl = document.getElementById('shareUrl');
            shareUrl.select();
            shareUrl.setSelectionRange(0, 99999);
            document.execCommand('copy');

            // Show feedback
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fa fa-check"></i> <span class="rtl-text">کپی شد!</span>';
            button.classList.add('btn-success');

            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('btn-success');
            }, 2000);
        }

        // Initialize QR Code
        function initializeQRCode() {
            const qrContainer = document.getElementById('qrcode');
            if (qrContainer && typeof QRCode !== 'undefined') {
                QRCode.toCanvas(qrContainer, window.location.href, {
                    width: 200,
                    height: 200,
                    color: {
                        dark: '#000000',
                        light: '#FFFFFF'
                    }
                });
            }
        }

        // Enhanced Keyboard Navigation
        function handleKeyboardNavigation(e) {
            // Only handle navigation if not in a form element
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA' || e.target.tagName === 'SELECT') {
                return;
            }

            switch (e.key) {
                case 'ArrowLeft':
                    if (isRTL) {
                        nextImage();
                    } else {
                        previousImage();
                    }
                    e.preventDefault();
                    break;
                case 'ArrowRight':
                    if (isRTL) {
                        previousImage();
                    } else {
                        nextImage();
                    }
                    e.preventDefault();
                    break;
                case 'Escape':
                    if (isZoomModalOpen) {
                        closeImageZoom();
                    }
                    e.preventDefault();
                    break;
                case 'Enter':
                case ' ':
                    if (e.target.classList.contains('main-image-container')) {
                        openImageZoom(e.target.querySelector('img').src);
                        e.preventDefault();
                    }
                    break;
                case 'Home':
                    if (productImages.length > 0) {
                        const firstThumbnail = document.querySelector('[data-index="0"]');
                        if (firstThumbnail) {
                            changeMainImage(productImages[0].src, firstThumbnail);
                        }
                        e.preventDefault();
                    }
                    break;
                case 'End':
                    if (productImages.length > 0) {
                        const lastIndex = productImages.length - 1;
                        const lastThumbnail = document.querySelector(`[data-index="${lastIndex}"]`);
                        if (lastThumbnail) {
                            changeMainImage(productImages[lastIndex].src, lastThumbnail);
                        }
                        e.preventDefault();
                    }
                    break;
            }
        }

        // Show Notification
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `notification notification-${type} rtl-notification`;
            notification.innerHTML = `
                <i class="fa fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} ml-2"></i>
                <span class="rtl-text">${message}</span>
            `;

            // Add to page
            document.body.appendChild(notification);

            // Show notification
            setTimeout(() => notification.classList.add('show'), 100);

            // Remove notification
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Update Cart Counter
        function updateCartCounter(count) {
            const cartCounter = document.querySelector('.cart-counter');
            if (cartCounter) {
                cartCounter.textContent = count;
                cartCounter.style.display = count > 0 ? 'block' : 'none';
            }
        }

        // Enhanced Lazy Loading with Intersection Observer
        function setupLazyLoading() {
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                                observer.unobserve(img);
                            }
                        }
                    });
                }, {
                    rootMargin: '50px 0px',
                    threshold: 0.01
                });

                const lazyImages = document.querySelectorAll('img[data-src]');
                lazyImages.forEach(img => imageObserver.observe(img));
            }

            // Fallback for browsers without IntersectionObserver
            if ('loading' in HTMLImageElement.prototype) {
                const images = document.querySelectorAll('img[loading="lazy"]');
                images.forEach(img => {
                    img.addEventListener('load', function() {
                        this.classList.add('loaded');
                    });
                    img.addEventListener('error', function() {
                        this.classList.add('error');
                    });
                });
            }
        }

        // Performance Optimization with Debouncing
        function debounce(func, wait, immediate = false) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    timeout = null;
                    if (!immediate) func(...args);
                };
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                if (callNow) func(...args);
            };
        }

        // Throttle function for scroll events
        function throttle(func, limit) {
            let inThrottle;
            return function() {
                const args = arguments;
                const context = this;
                if (!inThrottle) {
                    func.apply(context, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }

        // Preload next/previous images for better UX
        function preloadAdjacentImages() {
            const preloadIndexes = [];

            if (currentImageIndex > 0) {
                preloadIndexes.push(currentImageIndex - 1);
            }
            if (currentImageIndex < productImages.length - 1) {
                preloadIndexes.push(currentImageIndex + 1);
            }

            preloadIndexes.forEach(index => {
                const img = new Image();
                img.src = productImages[index].src;
            });
        }

        // Image preloading with priority
        function preloadImages() {
            // Preload main image first
            const mainImage = document.getElementById('main-product-image');
            if (mainImage && mainImage.src) {
                const img = new Image();
                img.src = mainImage.src;
            }

            // Preload adjacent images
            preloadAdjacentImages();
        }

        // RTL Support Functions
        if (isRTL) {
            // Add RTL-specific functionality
            document.body.classList.add('rtl-body');

            // RTL-specific animations
            const rtlElements = document.querySelectorAll('.rtl-text, .rtl-btn, .rtl-input');
            rtlElements.forEach(element => {
                element.style.direction = 'rtl';
                element.style.textAlign = 'right';
            });
        }
    </script>
    {{-- Clipboard JS --}}
    <script>
        function copyToClipboard() {
            const copyText = document.getElementById("shareUrl");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            alert("لینک کپی شد: " + copyText.value);
        }
    </script>
@endsection
