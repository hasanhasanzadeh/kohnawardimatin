<?php

use App\Http\Controllers\Panel\AttributeController;
use App\Http\Controllers\Panel\BaseController;
use App\Http\Controllers\Panel\AdminController;
use App\Http\Controllers\Panel\CouponController;
use App\Http\Controllers\Panel\OrderController;
use App\Http\Controllers\Panel\PaymentController;
use App\Http\Controllers\Panel\PostController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\ArticleController;
use App\Http\Controllers\Panel\BrandController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\CityController;
use App\Http\Controllers\Panel\CommentController;
use App\Http\Controllers\Panel\ContactController;
use App\Http\Controllers\Panel\CountryController;
use App\Http\Controllers\Panel\CustomerController;
use App\Http\Controllers\Panel\PageCatController;
use App\Http\Controllers\Panel\PageController;
use App\Http\Controllers\Panel\PermissionController;
use App\Http\Controllers\Panel\PhotoController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\ProvinceController;
use App\Http\Controllers\Panel\QuestionController;
use App\Http\Controllers\Panel\RoleController;
use App\Http\Controllers\Panel\SearchController;
use App\Http\Controllers\Panel\SendController;
use App\Http\Controllers\Panel\SettingController;
use App\Http\Controllers\Panel\SliderController;
use App\Http\Controllers\Panel\SymbolController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Middleware\LangLocale;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','LangLocale'])->prefix('panel')->group(function ($route){
    $route->resource('/articles',ArticleController::class);
    $route->resource('/customers',CustomerController::class);
    $route->resource('/settings',SettingController::class);
    $route->resource('/countries',CountryController::class);
    $route->resource('/provinces',ProvinceController::class);
    $route->resource('/cities',CityController::class);
    $route->resource('/symbols',SymbolController::class);
    $route->resource('/pages',PageController::class);
    $route->resource('/page_cats',PageCatController::class);
    $route->resource('/roles',RoleController::class);
    $route->resource('/questions',QuestionController::class);
    $route->resource('/permissions',PermissionController::class);
    $route->resource('/categories',CategoryController::class);
    $route->resource('/brands',BrandController::class);
    $route->resource('/products',ProductController::class);
    $route->resource('/sliders',SliderController::class);
    $route->resource('/categories',CategoryController::class);
    $route->resource('/bases',BaseController::class);
    $route->resource('/posts',PostController::class);
    $route->resource('/sends',SendController::class);
    $route->resource('/coupons',CouponController::class);

    $route->post('/attribute/values' , AttributeController::class);

    $route->get('/payments',[PaymentController::class,'index'])->name('payments.index');

    $route->get('/specials',[ProductController::class,'specials'])->name('products.specials');

    $route->post('/orders/search',[OrderController::class,'search'])->name('orders.search');

    $route->get('/orders',[OrderController::class,'index'])->name('orders.index');
    $route->get('/orders/{id}',[OrderController::class,'show'])->name('orders.show');
    $route->get('/orders/print/{id}',[OrderController::class,'print'])->name('orders.print');
    $route->get('/orders/edit/{id}',[OrderController::class,'edit'])->name('orders.edit');
    $route->post('/orders/update/{id}',[OrderController::class,'update'])->name('orders.update');

    $route->get('/comments',[CommentController::class,'index'])->name('comments.index');
    $route->get('/comments/{comment}',[CommentController::class,'show'])->name('comments.show');
    $route->delete('/comments/{comment}',[CommentController::class,'destroy'])->name('comments.destroy');
    $route->get('/comments/answer/{comment}',[CommentController::class,'answerShow'])->name('comments.answer');
    $route->post('/comments/answer-save/{comment}',[CommentController::class,'answerSave'])->name('answer.save');

    $route->get('/properties/category/{id}',[CategoryController::class,"setProperty"])->name('property.category');
    $route->post('/property/category',[CategoryController::class,"propertyUpdate"])->name('properties.category');
    $route->delete('/property/destroy/{id}',[CategoryController::class,"propertyDestroy"])->name('category.property.destroy');

    $route->get('/searches',[SearchController::class,'index'])->name('searches.index');
    $route->delete('/searches/{id}',[SearchController::class,'destroy'])->name('searches.destroy');
    $route->post('/upload-image',[PhotoController::class,'uploadImage'])->name('img.upload');
    $route->get('/admin',[AdminController::class,'index'])->name('panel.admin');
    $route->get('/',[AdminController::class,'index'])->name('panel.index');
    $route->post('/photo/store',[PhotoController::class,'store'])->name('photo.upload');
    $route->get('/photo/delete/{id}',[PhotoController::class,'destroy'])->name('photo.destroy');
    $route->get('/photo/show/{id}',[PhotoController::class,'show'])->name('photo.show');

    $route->get('/contacts',[ContactController::class,'index'])->name('contacts.index');
    $route->get('/contacts/{contact}',[ContactController::class,'show'])->name('contacts.show');
    $route->delete('/contacts/{contact}',[ContactController::class,'destroy'])->name('contacts.destroy');

    $route->get('/products/status/{product}',[ProductController::class,'changeStatus'])->name('products.status');
    $route->get('/comments/status/{comment}',[CommentController::class,'changeStatus'])->name('comments.status');

    $route->get('/customer/search',[CustomerController::class,'search'])->name('customers.search');

    $route->get('/profile',[ProfileController::class,'show'])->name('profile.show');
    $route->get('/profile/edit',[ProfileController::class,'edit'])->name('profile.edit');
    $route->post('/profile/update',[ProfileController::class,'update'])->name('profile.update');

    $route->post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    $route->delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    $route->post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    $route->delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');

    $route->get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    $route->delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    $route->post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    $route->delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    $route->post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    $route->delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');

    $route->get('/permission/search',[PermissionController::class,'search'])->name('permission.search');
    $route->get('/province/search',[ProvinceController::class,'search'])->name('province.search');
    $route->get('/page_cat/search',[PageCatController::class,'search'])->name('page_cat.search');
    $route->get('/country/search',[CountryController::class,'search'])->name('country.search');
    $route->get('/city/search',[CityController::class,'search'])->name('city.search');
    $route->get('/category/search',[CategoryController::class,'search'])->name('category.search');
    $route->get('/slider/search',[SliderController::class,'search'])->name('slider.search');
    $route->get('/brand/search',[BrandController::class,'search'])->name('brand.search');
    $route->post('/make/slug',[AdminController::class,'makeSlug'])->name('make.slug');
})->middleware('LangLocale');
