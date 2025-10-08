<?php

use App\Http\Controllers\Web\FeedController;
use App\Http\Controllers\Web\MainController;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\SitemapController;
use App\Http\Controllers\Web\ArticleController;
use App\Http\Controllers\Web\BrandController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Web\SpecialController;
use Illuminate\Support\Facades\Route;


Route::namespace('App\Http\Controllers\Web')->group(function ($route){

    $route->get('/',[MainController::class,'index'])->name('index.welcome');
    $route->get('/index',[MainController::class,'index'])->name('home.index');
    $route->get('/home',[MainController::class,'index'])->name('home.welcome');

    $route->get('/cart' , [CartController::class,'cart'])->name('carts.index');
    $route->post('/cart/add' ,[ CartController::class,'addToCart'])->name('cart.add');
    $route->post('/cart/change' , [CartController::class,'quantityChange'])->name('cart.change');
    $route->post('/cart/changed' , [CartController::class,'quantity'])->name('cart.changed');
    $route->delete('/cart/delete/{cart}' ,[ CartController::class,'deleteFromCart'])->name('cart.destroy');

    $route->get('/product/show/{slug}',[ProductController::class,'slug'])->name('product.show');
    $route->get('/category/show/{slug}',[CategoryController::class,'slug'])->name('category.show');
    $route->get('/brand/show/{slug}',[BrandController::class,'slug'])->name('brand.show');
    $route->get('/article/show/{slug}',[ArticleController::class,'slug'])->name('article.show');

    $route->get('/brand/all',[BrandController::class,'index'])->name('brand.index');
    $route->get('/brands/all',[BrandController::class,'all'])->name('brand.all');

    $route->get('/special/product',[SpecialController::class,'index'])->name('special.index');

    $route->get('/products/search',[SearchController::class,'search'])->name('products.search');
    $route->get('/cats/all',[CategoryController::class,'index'])->name('cats.all');

    $route->get('/article',[ArticleController::class,'index'])->name('article.index');

    $route->get('/about-us',[PageController::class,'about'])->name('about.show');
    $route->get('/contact-us',[PageController::class,'contact'])->name('contact.show');
    $route->post('/contact',[PageController::class,'contactSave'])->name('contact.store');
    $route->get('/question',[PageController::class,'question'])->name('question.show');
    $route->get('/aims',[PageController::class,'aims'])->name('aims.show');
    $route->get('/page/{slug}',[PageController::class,'page'])->name('page.show');

    $route->get('/sitemap.xml',[SitemapController::class,'index']);
    $route->get('/feed',[FeedController::class,'index']);
});
