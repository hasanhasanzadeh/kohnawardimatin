<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Product;

class FeedController extends Controller
{
    public function index()
    {
        $products=Product::with(['photo','categories','brand','meta'])
            ->where('status',1)
            ->latest()
            ->get();
        $categories=Category::with(['products','photo','meta'])
            ->where('status',1)
            ->latest()
            ->get();
        $articles=Article::with(['photo','meta'])
            ->where('status',1)
            ->latest()
            ->get();
        return view('front.feed.index',compact(['products','categories','articles']));
    }
}
