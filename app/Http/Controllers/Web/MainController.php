<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index()
    {
        $helper=Helper::arrayGetAll();
        $title=$helper['setting']->title;
        SEOMeta::setTitle($helper['setting']->title);
        SEOMeta::setDescription($helper['setting']->meta?$helper['setting']->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$helper['setting']->meta?$helper['setting']->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        $new_products=Product::with('photo')->whereIn('status',['active','soon'])->latest()->take(18)->get();
        return view('welcome',compact(['title','helper','new_products']));
    }

    public function citySearch(Request $request)
    {
        $cities = [];
        if($request->has('q')){
            $search = $request->q;
            $cities = City::with(['province.country'])->select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($cities);
    }

    public function brandSearch(Request $request)
    {
        $brands = [];
        if($request->has('q')){
            $search = $request->q;
            $brands = Brand::select("id", "title")
                ->where('title', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($brands);
    }

    public function categorySearch(Request $request)
    {
        $categories = [];
        if($request->has('q')){
            $search = $request->q;
            $categories = Category::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($categories);
    }
}
