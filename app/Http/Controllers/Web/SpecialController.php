<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use SEO;

class SpecialController extends Controller
{
    public function index(Request $request)
    {
        $search=request('title');
        $brands=Brand::all();
        $show_products=Product::query();
        if ($search){
            $show_products = $show_products->where('title', 'LIKE', "%{$search}%")->orWhere('original_name','like',"%%{$search}");
        }
        if (!empty($request->category_id)) {
            $categoryIds = explode(',', $request->category_id);

            $show_products = $show_products->where(function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds)
                    ->orWhereHas('categories', function ($q) use ($categoryIds) {
                        $q->whereIn('id', $categoryIds)
                            ->orWhereIn('parent_id', $categoryIds);
                    });
            });
        }
        if($request->quantity){
            $show_products = $show_products
                ->where('quantity',">", 0 );
        }
        if ($request->brand_id!=null){
            $brand_id = explode(",",$request->brand_id);
            $show_products = $show_products
                ->whereIn('brand_id',$brand_id);
        }
        $show_products=$show_products->with(['photo','meta'])->whereIn('status',['active','soon'])->latest()->paginate(36);
        $helper=Helper::arrayGetAll();
        $title='محصولات شگفت انگیز';
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        return view('web.specials.index', compact(['user','show_products','helper','brands','search','title']));
    }
}
