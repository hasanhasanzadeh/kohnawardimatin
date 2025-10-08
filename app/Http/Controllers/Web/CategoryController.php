<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use SEO;

class CategoryController extends Controller
{

    public function index()
    {
        $helper = Helper::arrayGetAll();
        $title='نمایش دسته ها';
        $cats = Category::with(['photo'])->orderBy('id', 'desc')->get();
        return view('web.categories.index', compact(
            ['cats',
            'helper',
            'title'
            ]));
    }

    public function slug($slug)
    {
        // Load category and its relationships
        $cat = Category::with(['products', 'childrenRecursive', 'meta'])
            ->where('slug', $slug)
            ->firstOrFail();

        $title = 'دسته ' . $cat->name;
        $search = $cat->name;
        $brands = Brand::all();
        $user = auth()->check() ? auth()->user() : null;

        $validStatuses = ['active', 'soon'];

        // Start product query
        $show_products = Product::query()
            ->with(['photo', 'categories', 'brand'])
            ->whereIn('status', $validStatuses)
            ->whereHas('categories', function ($query) use ($cat) {
                $query->where('categories.id', $cat->id)
                    ->orWhere('categories.parent_id', $cat->id);
            })->latest();

        // Filter by title
        if (request()->filled('title')) {
            $title = request('title');
            $show_products->where(function ($query) use ($title) {
                $query->where('title', 'LIKE', "%{$title}%")
                    ->orWhere('original_name', 'LIKE', "%{$title}%");
            });
        }

        if (request()->filled('category')) {
            $cat_ids = request('category');
            $show_products->whereHas('categories', function ($query) use ($cat_ids) {
                $query->whereIn('categories.id', $cat_ids)
                    ->orWhereIn('categories.parent_id', $cat_ids);
            });

        }

        if (request()->filled('brand')) {
            $brand_ids = request('brand');
            $show_products->whereHas('brand', function ($query) use ($brand_ids) {
                $query->whereIn('brands.id', $brand_ids);
            });
        }

        $show_products = $show_products
            ->sortable()
            ->paginate(60);

        $helper = Helper::arrayGetAll();

        return view('web.categories.show', compact(
            'show_products',
            'cat',
            'brands',
            'user',
            'search',
            'helper',
            'title'
        ));
    }
}
