<?php

namespace App\Http\Controllers\Web;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;

class ArticleController extends Controller
{
    public function index()
    {
        $title='مقالات';
        $helper=Helper::arrayGetAll();
        $user=auth()->check()?User::with('photo')->findOrFail(auth()->user()->id):null;
        $articles=Article::with(['photo','user'])->whereDate('publish_date','<=',today()->format('Y-m-d'))->where('status',1)->sortable()->latest()->paginate(20);
        $article=$articles->first();
        SEOMeta::setTitle($article->title??'');
        SEOMeta::setDescription($article->meta?$article->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$article->meta?$article->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.articles.index', compact(['user','helper','title','articles']));
    }

    public function slug($slug)
    {
        $article=Article::with('photo')
            ->where('slug',$slug)
            ->firstOrFail();
        $helper=Helper::arrayGetAll();
        $article->increment('view_count');
        $title='بلاگ '.$article->title;
        $user=auth()->check()?User::findOrFail(auth()->user()->id):null;
        $articles=Article::with('photo')->sortable()->latest()->paginate(10);
        SEOMeta::setTitle($article->title);
        SEOMeta::setDescription($article->meta?$article->meta->meta_description:null);
        SEOMeta::setKeywords(explode('-',$article->meta?$article->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('web.articles.show',compact(['helper','user','title','article','articles']));
    }


}
