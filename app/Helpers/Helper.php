<?php

namespace App\Helpers;

use App\Models\Article;
use App\Models\Base;
use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Coupon;
use App\Models\File;
use App\Models\Page_Cat;
use App\Models\Payment;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class Helper
{

    public static function persianToLatin($persianText): string
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $latinNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $latinText = strtr($persianText, array_combine($persianNumbers, $latinNumbers));

        return $latinText;
    }

    public static function convertPersianToEnglishNumbers($input): array|string
    {
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($persianNumbers, $englishNumbers, $input);
    }

    public static function arrayGetAll(): array
    {
        $setting = Setting::with(['favicon','logo','symbols','media'])->first();
        $categories=Category::with(['photo','children'])->where('parent_id',0)->latest()->get();
        $cart = Cart::with('products')->where('session_id',Session::get('User_Temp_Id'))->latest()->first()??null;
        $articles_show=Article::whereDate('publish_date','<=',today()->format('Y-m-d'))->latest()->where('status',1)->inRandomOrder()->take(24)->get();
        $bases=Base::latest()->where('status',1)->get();
        $coupon = Coupon::whereDate('expired_at','>=',Carbon::now()->format('Y-m-d'))->where('status',1)->latest()->first();
        $page_cats=Page_Cat::with(['pages'])->latest()->get();
        $sliders=Slider::with('category')->where('status',1)->where('rang','slider')->inRandomOrder()->get();
        $banner=Slider::with('category')->where('status',1)->where('rang','banner')->inRandomOrder()->first();
        $products=Product::with('photo')->where('status','active')->inRandomOrder()->take(12)->get();
        $specials=Product::with('photo')->where('special',1)->where('status','active')->whereDate('expired_at','>=',Carbon::now())->inRandomOrder()->take(7)->get();
        $steps=Slider::with('category')->where('status',1)->where('rang','!=','banner')->where('rang','!=','slider')->inRandomOrder()->get();
        $banners=Slider::with('category')->where('status',1)->where('rang','!=','banner')->where('rang','!=','slider')->inRandomOrder()->get();

        $validProductStatuses = ['active', 'soon'];

        $product_cats = Category::with([
            'products' => function ($query) use ($validProductStatuses) {
                $query->whereIn('status', $validProductStatuses)
                    ->latest()
                    ->take(12);
            }
        ])->where('status', 1)
            ->whereHas('products', function ($query) use ($validProductStatuses) {
                $query->whereIn('status', $validProductStatuses);
            })->latest()->get();


        $medias=$setting->media;
        $brands_show=Brand::with('photo')->where('status',1)->inRandomOrder()->take(27)->get();
        return compact(['medias','coupon','setting','categories','cart','articles_show','page_cats','sliders','banner','product_cats','products','specials','banners','brands_show','steps','bases']);
    }

    public static function makeSlug($title): array|string|null
    {
        $string=str_replace(['/',"\\",'%','#','!','@','$','^','&','*','(',')','_','=',"'",'"'],'',$title);
        return preg_replace('/\s+/u', '-', strtolower(trim($string)));
    }

    public static function uploadImage($file, $slug=null)
    {
        if (!$slug){
            $image = new File();
            $image->path = str_replace('public','storage',$file->store('public/uploads'));
            $image->save();
            return $image->id;
        }
        $extension = $file->getClientOriginalExtension();

        $filename = $slug . '-' . uniqid() . '.' . $extension;

        $path = $file->storeAs('public/uploads', $filename);

        $image = new File();
        $image->path = str_replace('public', 'storage', $path);
        $image->save();

        return $image->id;
    }
    public static function generateSKU(): string
    {
        $number = mt_rand(1000, 999999);
        if(Helper::checkSKU($number)){
            return Helper::generateSKU();
        }
        return (string)'KM'.$number;
    }

    public static function checkSKU($number)
    {
        return Product::where('sku', $number)->exists();
    }

    public static function alerts(): array
    {
        $userTodayCount = User::whereDate('created_at', today())->count();
        $contactTodayCount = Contact::whereDate('created_at', today())->where('read',0)->count();
        $paymentTodayCount = Payment::whereDate('created_at', today())->count();
        $commentTodayCount = Comment::whereDate('created_at', today())->where('status',false)->count();
        return $data = [
            'userTodayCount' => $userTodayCount,
            'contactTodayCount' => $contactTodayCount,
            'paymentTodayCount' => $paymentTodayCount,
            'commentTodayCount' => $commentTodayCount,
        ];
    }

    public static function DashboardAlert(): array
    {
        $userCount = User::all()->count();
        $contactCount = Contact::all()->count();
        $paymentCount = Payment::all()->count();
        $commentCount = Comment::all()->count();
        return $data = [
            'userCount' => $userCount,
            'contactCount' => $contactCount,
            'paymentCount' => $paymentCount,
            'commentCount' => $commentCount,
        ];
    }

    public static function posts(){
        return Post::where('status',true)->where('price','>','0')->get();
    }

    public static function notification($title, $notifyTitle, $notifyDescription, $email): void
    {
            $setting = Setting::with(['favicon', 'logo', 'meta', 'media'])->first();
            $details = [
                'text_subject' => $title,
                'media' => $setting->media,
                'subject' => $notifyTitle,
                'text' => $notifyDescription,
            ];
            Mail::to($email)->send(new \App\Mail\DefaultMail($details, $setting));
    }

}
