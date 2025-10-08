<?php

use App\Helpers\NotificationMobile;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__.'/front/main.php';

require __DIR__.'/front/user.php';

require __DIR__.'/panel/admin.php';

require __DIR__.'/panel/auth.php';

Route::get('/clear',function (){
    Illuminate\Support\Facades\Artisan::call('optimize:clear');
    Illuminate\Support\Facades\Artisan::call('storage:link');
    Illuminate\Support\Facades\Artisan::call('config:cache');
    Illuminate\Support\Facades\Artisan::call('route:cache');
    Illuminate\Support\Facades\Artisan::call('view:cache');
	return redirect()->back();
});
