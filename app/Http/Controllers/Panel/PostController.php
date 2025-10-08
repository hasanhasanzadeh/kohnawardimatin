<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PostController extends Controller
{


    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.posts');
        $posts = Post::query();
        if ($keyword = request('search')) {
            $posts->where('title', 'LIKE', "%{$keyword}%");
        }
        $posts = $posts->with(['photo'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.post.index', compact(['posts', 'user', 'title', 'setting']));
    }


    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.post.create', compact(['user', 'title', 'setting']));
    }

    public function store(PostRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Helper::makeSlug($request->slug);
        $post->description = $request->description;
        $post->status = $request->status;
        $post->price = $request->price;
        $post->const_price = $request->const_price;
        $post->payment_state = $request->payment_state;
        $post->url = $request->url;
        $post->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $post->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.created'), 'success');
        return redirect()->route('posts.index');
    }


    public function show(Post $post)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.post.show', compact(['user', 'title', 'post', 'setting']));
    }


    public function edit(Post $post)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.post.edit', compact(['user', 'title', 'post', 'setting']));
    }


    public function update(PostRequest $request, Post $post)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $post->title = $request->title;
        $post->slug = Helper::makeSlug($request->slug);
        $post->description = $request->description;
        $post->status = $request->status;
        $post->price = $request->price;
        $post->const_price = $request->const_price;
        $post->payment_state = $request->payment_state;
        $post->url = $request->url;
        $post->save();
        if ($request->file('image')){
            $post->photo?$post->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $post->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'), 'success');
        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('post-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $post->delete();
        toast(__('dashboard.deleted'), 'success');
        toast('اطلاعات پستی قابل حذف نمی باشد', 'success');
        return redirect()->back();
    }
}
