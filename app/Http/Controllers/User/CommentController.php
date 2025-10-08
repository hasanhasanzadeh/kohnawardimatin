<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Alert;
use App\Models\Bale;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Page_Cat;
use App\Models\Setting;
use App\Models\User;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Http\Request;

class CommentController extends Controller
{



    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        $title = __('dashboard.comments');
        $comments = Comment::query();
        if ($keyword = request('search')) {
            $comments->where('message', 'LIKE', "%{$keyword}%");
        }
        $comments = $comments->with(['comments'])->where('user_id',$user->id)->latest()->paginate(20);
        $locale = config('app.locale');
        $setting = Setting::with('language')->whereHas('language', function ($query)use($locale){
            $query->where('lang',$locale);
        })->first();
        $bale = new Bale();
        if (!$setting) {
            $setting = Setting::with(['favicon','logo','language'])->first();
        }
        $alert=Alert::with('language')->where('status',1)
            ->whereHas('language',function ($query) use($locale){
                $query->where('lang',$locale);
            })->latest()
            ->first();
        $categories=Category::with(['photo','children','language'])
            ->whereHas('language',function ($query) use($locale){
                $query->where('lang',$locale);
            })->where('status',1)
            ->where('parent_id',0)
            ->latest()
            ->get();
        $page_cats=Page_Cat::with(['pages','language'])
            ->whereHas('language',function ($query) use($locale){
                $query->where('lang',$locale);
            })->latest()
            ->get();
        SEOMeta::setTitle($setting->title);
        SEOMeta::setDescription($setting->meta_id?$setting->meta->meta_description:null);
        SEOMeta::setKeywords(explode(' ',$setting->meta_id?$setting->meta->meta_keywords:null));
        SEOMeta::setCanonical(env('FRONT_URL'));
        return view('user.comment.index', compact(['comments', 'user', 'title', 'setting', 'bale','title','alert','categories','page_cats']));

    }
    public function store(CommentRequest $request)
    {
        $comment=new Comment();
        $comment->parent_id=$request->parent_id;
        $comment->commentable_id=$request->commentable_id;
        $comment->commentable_type=$request->commentable_type;
        $comment->message=$request->description;
        $comment->user_id=auth()->user()->id;
        $comment->save();
        toast(__('dashboard.created'),'success');
        return back();
    }
}
