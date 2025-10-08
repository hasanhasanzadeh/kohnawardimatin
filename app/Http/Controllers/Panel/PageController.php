<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;

class PageController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.pages');
        $pages = Page::query();
        if($keyword = request('search')) {
            $pages->where('title' , 'LIKE' , "%{$keyword}%");
        }
        $pages=$pages->with(['page_cat','photo'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page.index',compact(['pages','user','title','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page.create',compact(['title','user','setting']));
    }

    public function store(PageRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $page=new Page();
        $page->title=$request->title;
        $page->slug=Helper::makeSlug($request->slug);
        $page->description=$request->description;
        $page->status=$request->status;
        $page->page_cat_id=$request->page_cat_id;
        $page->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $page->photo()->create(['path'=>$path]);
        }
        $page->meta()->create([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.created'),'success');
        return redirect()->route('pages.index');

    }

    public function show(Page $page)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page.show',compact(['page','user','title','setting']));
    }

    public function edit(Page $page)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.edit');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page.edit',compact(['page','user','title','setting']));
    }

    public function update(PageUpdateRequest $request, Page $page)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $page->title=$request->title;
        $page->slug=Helper::makeSlug($request->slug);
        $page->description=$request->description;
        $page->status=$request->status;
        $page->page_cat_id=$request->page_cat_id;
        $page->save();
        if ($request->file('image')){
            $page->photo?$page->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $page->photo()->create(['path'=>$path]);
        }
        $page->meta()->find($page->meta->id)->update([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.updated'),'success');
        return redirect()->route('pages.index');
    }

    public function destroy($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $page=Page::findOrFail($id)->delete();
        toast(__('dashboard.deleted'),'success');
        return redirect()->route('pages.index');

    }

}
