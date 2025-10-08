<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;

class ArticleController extends Controller
{


    public function index()
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-all')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $title = __('dashboard.articles');
        $articles = Article::query();
        if ($keyword = request('search')) {
            $articles->where('title', 'LIKE', "%{$keyword}%");
        }
        $articles = $articles->with(['photo'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon', 'logo'])->first();
        return view('panel.article.index', compact(['articles', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-create')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon', 'logo'])->first();
        return view('panel.article.create', compact(['user', 'title', 'setting']));
    }

    public function store(ArticleRequest $request)
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-store')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $publish_date = $request->publish_date ?? Carbon::now()->format('Y-m-d');
        $article = new Article();
        $article->title = $request->title;
        $article->slug = Helper::makeSlug($request->slug);
        $article->description = $request->description;
        $article->body = $request->body;
        $article->status = $request->status;
        $article->publish_date = $publish_date;
        $article->user_id = auth()->user()->id;
        $article->save();
        if ($request->file('image')) {
            $path = str_replace('public', 'storage', $request->file('image')->store('public/uploads'));
            $article->photo()->create(['path' => $path]);
        }
        $article->meta()->create([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        toast(__('dashboard.created'), 'success');
        return redirect()->route('articles.index');
    }


    public function show(Article $article)
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-find')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo', 'favicon'])->first();
        return view('panel.article.show', compact(['user', 'title', 'article', 'setting']));
    }


    public function edit(Article $article)
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-edit')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo', 'favicon'])->first();
        return view('panel.article.edit', compact(['user', 'title', 'article', 'setting']));
    }


    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-update')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $publish_date = $request->publish_date ?? $article->publish_date;
        $article->title = $request->title;
        $article->slug = Helper::makeSlug($request->slug);
        $article->description = $request->description;
        $article->body = $request->body;
        $article->status = $request->status;
        $article->publish_date = $publish_date;
        $article->save();
        if ($request->file('image')) {
            $article->photo()->delete();
            $path = str_replace('public', 'storage', $request->file('image')->store('public/uploads'));
            $article->photo()->create(['path' => $path]);
        }
        $article->meta()->find($article->meta->id)->update([
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description
        ]);
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $user = User::with('photo')->findOrFail(auth()->user()->id);
        if (!$user->can('article-delete')) {
            abort(403, __('dashboard.accessDenied'));
        }
        $article->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

}
