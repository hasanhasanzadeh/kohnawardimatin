<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageCatRequest;
use App\Models\Page;
use App\Models\Page_Cat;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class PageCatController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.page_cats');
        $page_cats = Page_Cat::query();
        if($keyword = request('search')) {
            $page_cats->where('name' , 'LIKE' , "%{$keyword}%");
        }
        $page_cats=$page_cats->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page_cat.index',compact(['page_cats','user','title','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page_cat.create',compact(['title','user','setting']));
    }

    public function store(PageCatRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $page_cat=new Page_Cat();
        $page_cat->name=$request->title;
        $page_cat->save();
        toast(__('dashboard.created'),'success');
        return redirect()->route('page_cats.index');

    }

    public function show(Page_Cat $page_cat)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page_cat.show',compact(['page_cat','user','title','setting']));
    }

    public function edit(Page_Cat $page_cat)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.edit');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.page_cat.edit',compact(['page_cat','user','title','setting']));
    }

    public function update(PageCatRequest $request, $id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $page_cat=Page_Cat::findOrFail($id);
        $page_cat->name=$request->title;
        $page_cat->save();
        toast(__('dashboard.updated'),'success');
        return redirect()->route('page_cats.index');
    }

    public function destroy($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('page-cat-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $page=Page::where('page_cat_id',$id)->first();
        if (!$page)
        {
            $page_cat=Page_Cat::findOrFail($id)->delete();
            toast(__('dashboard.deleted'),'success');
        }
        else{
            toast(__('dashboard.warning'),'error');
        }
        return redirect()->route('page_cats.index');

    }


    public function search(Request $request)
    {
        $page_cats = [];
        if($request->has('q')){
            $search = $request->q;
            $page_cats = Page_Cat::select("id", "name")
                ->where('name', 'LIKE', "%$search%")
                ->get();
        }
        return response()->json($page_cats);
    }
}
