<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Search;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function search()
    {
        $title = __('dashboard.search');
        $search = request('title');
        $categoryIds = request('category');
        $brandIds = request('brand');
        $statuses = ['active', 'soon'];

        $show_products = Product::query()
            ->with(['categories', 'brand', 'photo'])
            ->whereIn('status', $statuses)
            ->latest();

        // Title-based search
        if (!empty($search)) {
            $show_products->where(function ($query) use ($search) {
                $query->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('original_name', 'LIKE', "%{$search}%");
            });

            // Track searches (between 5 and 20 chars)
            if (Str::length($search) >= 5 && Str::length($search) <= 20) {
                $this->searchStore(request());
            }
        }

        // Filter by category
        if (!empty($categoryIds)) {
            $show_products->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds)
                    ->orWhereIn('categories.parent_id', $categoryIds);
            });
        }

        // Filter by brand
        if (!empty($brandIds)) {
            $show_products->whereHas('brand', function ($query) use ($brandIds) {
                $query->whereIn('brands.id', $brandIds);
            });
        }

        // Final query execution
        $show_products = $show_products
            ->sortable()
            ->paginate(60);

        $helper = Helper::arrayGetAll();

        return view('web.searches.index', compact(
            'search',
            'helper',
            'title',
            'show_products'
        ));
    }

    public function searchStore($request)
    {
            $search=new Search();
            $search->ip_address=$request->ip();
            $search->search_text=$request->title;
            $search->user_id=auth()->check()?auth()->user()->id:null;
            $search->save();
    }
}
