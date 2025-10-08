<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use SEO;

class BrandController extends Controller
{
    public function slug($slug)
    {
        $brand_show=Brand::with('photo','meta')
            ->where('slug',$slug)
            ->firstOrFail();
        $title='برند '.$brand_show->title;
        $showProducts=Product::with(['photo','brand'])
            ->whereHas('brand',function ($brandQuery)use($brand_show){
                $brandQuery->where('id',$brand_show->id);
            })
            ->whereIn('status',['active','soon'])
            ->inRandomOrder()
            ->take(16)
            ->get();
        $helper=Helper::arrayGetAll();
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        SEOMeta::setTitle($brand_show->title);
        SEOMeta::setDescription($brand_show->meta?$brand_show->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$brand_show->meta?$brand_show->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.brands.show', compact(['helper','user','showProducts','brand_show','title']));
    }

    public function index()
    {
        $title='برند ها';
        $brands_show=Brand::with('photo','meta')
            ->sortable()->latest()->get();
        $brand_ids=$brands_show->pluck('id');

        $products_show=Product::query();
        if (!request('brand') && !request('category')){
            $products_show = $products_show->with(['photo', 'brand'])
                ->whereHas('brand', function ($queryBrand) use ($brand_ids) {
                    $queryBrand->whereIn('id', $brand_ids);
                });
        }
        if (request('title')){
            $title=request('title');
            $products_show=$products_show->where('title','LIKE',"%{$title}%")
                ->orWhere('original_name','LIKE',"%{$title}%");
        }
        if (request('category')){
            $cat_ids=request('category');
            $products_show=$products_show->with('category')
                ->whereHas('category',function ($query)use($cat_ids){
                    $query->whereIn('id',$cat_ids)->orWhereIn('parent_id',$cat_ids);
                });
        }
        if (request('brand')){
            $brand_id=request('brand');
            $products_show=$products_show->with('brand')
                ->whereHas('brand',function ($q)use($brand_id){
                    $q->whereIn('id',$brand_id);
                });
        }
        $products_show=$products_show->with(['category','brand','photo'])
            ->whereIn('status',['active','soon'])
            ->inRandomOrder()
            ->sortable()->latest()
            ->paginate(32);

        $helper=Helper::arrayGetAll();
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        SEOMeta::setTitle($brands_show->last()->title);
        SEOMeta::setDescription($brands_show->last()->meta?$brands_show->last()->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$brands_show->last()->meta?$brands_show->last()->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.brands.index', compact(['helper','user','products_show','brands_show','title']));
    }

    public function all()
    {
        $title = 'برند ها';
        $brands = Brand::with(['photo', 'meta'])->sortable()->latest()->paginate(20);
        $helper = Helper::arrayGetAll();
        $user = auth()->user();
        $currentBrand = $brands->first();
        SEOMeta::setTitle($currentBrand->title ?? $title);
        SEOMeta::setDescription(optional($currentBrand->meta)->meta_description);
        SEOMeta::setKeywords(optional($currentBrand->meta)->meta_keywords ? explode('-', $currentBrand->meta->meta_keywords) : []);
        SEOMeta::setCanonical(config('app.front_url', env('FRONT_URL')));

        return view('web.brands.all', compact(['helper', 'user', 'brands', 'title']));
    }
}
