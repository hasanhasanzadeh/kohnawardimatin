<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductAttributeValues;
use App\Models\Setting;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\DB;
use SEO;

class ProductController extends Controller
{
    public function search($slug)
    {
        $title='جستجوی محصولات';
        $product=Product::with('photo','categories','brand','meta')
            ->where('slug',$slug)
            ->whereIn('status',['active','soon'])
            ->firstOrFail();
        $product->increment('view_count');;
        $comments=$product->comments()->where('status',1)
            ->where('parent_id',0)
            ->latest()
            ->with(['comments'=>function ($query){
            $query->where('status',1)
                ->latest();
        }])->paginate(10);
        $helper=Helper::arrayGetAll();
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        SEOMeta::setTitle($product->title);
        SEOMeta::setDescription($product->meta?$product->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$product->meta?$product->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.products.index', compact(['helper','user','product','comments','title']));

    }

    public function slug($slug)
    {
        $product=Product::with(['photo','categories','brand','meta','attributes'])
            ->whereIn('status',['active','soon'])
            ->where('slug',$slug)
            ->firstOrFail();

        $titleWords = explode(' ', $product->title);

        $product_ms = Product::with(['photo', 'categories', 'brand', 'meta'])
            ->whereIn('status',['active','soon'])
            ->where('id', '!=', $product->id) // Exclude the original product
            ->where(function ($query) use ($titleWords) {
                foreach ($titleWords as $word) {
                    $query->orWhere('title', 'like', "%$word%");
                }
            })
            ->latest()
            ->take(15)
            ->get();
        $product->increment('view_count');;
        $comments=$product->comments()->where('status',1)
            ->where('parent_id',0)
            ->latest()
            ->with(['comments'=>function ($query){
                $query->where('status',1)
                    ->latest();
            }])->paginate(10);
        $helper=Helper::arrayGetAll();
        $title=$product->title;
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        SEOMeta::setTitle($product->title);
        SEOMeta::setDescription($product->meta?$product->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$product->meta?$product->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        $attributes = $product->attributes()
            ->with(['values'])
            ->get()
            ->groupBy('pivot.attribute_id')
            ->map(function ($group) {
                $firstItem = $group->first();
                return [
                    'attribute_id' => $firstItem->pivot->attribute_id,
                    'attribute_name' => $firstItem->name, // Assuming 'name' is a field in the Attribute model
                    'count' => $group->count(),
                    'values' => $group->pluck('pivot.value_id'), // Collecting value_ids from the pivot table
                ];
            });
        $setting = Setting::with(['logo','favicon','meta'])->first();
        return view('web.products.index', compact(['attributes','product_ms','helper','user','product','comments','title','setting']));
    }

}
