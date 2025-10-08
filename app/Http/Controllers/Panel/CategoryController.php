<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.category');
        $setting = Setting::with(['favicon','logo'])->first();
        $categories = Category::query();

        if ($keyword = request('search')) {
            $categories->where(function($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhereHas('parents', function($q) use ($keyword) {
                        $q->where('name', 'LIKE', "%{$keyword}%");
                    });
            });
        }
        $categories=$categories->with('photo','children','user')->where('parent_id',0)->sortable()->latest()->paginate(10);
        return view('panel.category.index',compact(['categories','user','title','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.category.create',compact(['title','user','setting']));
    }

    public function store(CategoryRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $parent_id=$request->parent_id??0;
        $category=new Category();
        $category->name=$request->name;
        $category->slug=Helper::makeSlug($request->slug);
        $category->parent_id=$parent_id;
        $category->status=$request->status;
        $category->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $category->photo()->create(['path'=>$path]);
        }
        $category->meta()->create([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        toast(__('dashboard.created'),'success');
        return redirect()->route('categories.index');

    }

    public function show(Category $category)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-show'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.category.show',compact(['category','user','title','setting']));
    }

    public function edit(Category $category)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['favicon','logo'])->first();
        $categories=Category::with('photo','children')->where('parent_id',null)->get();
        return view('panel.category.edit',compact(['category','user','title','categories','setting']));
    }


    public function update(CategoryRequest $request, Category $category)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $parent_id=$request->parent_id;
        if ($parent_id!=0){
            $cat=Category::find($parent_id);
            if ($request->parent_id==$category->id || $request->parent_id==null || $request->parent_id=='NULL' || $category->id==$cat->parent_id){
                $parent_id=$category->parent_id;
            }
        }
        if ($request->parent_id == null) {
            $parent_id = 0;
        }
        $category->name=$request->name;
        $category->slug=Helper::makeSlug($request->slug);
        $category->parent_id=$parent_id;
        $category->status=$request->status;
        $category->save();
        if ($request->file('image')){
            $category->photo?$category->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $category->photo()->create(['path'=>$path]);
        }
        if ($category->meta){
            $category->meta()->find($category->meta->id)->update([
                'meta_title'=>$request->meta_title,
                'meta_keywords'=>$request->meta_keywords,
                'meta_description'=>$request->meta_description
            ]);
        }else{
            $category->meta()->create([
                'meta_title'=>$request->meta_title,
                'meta_keywords'=>$request->meta_keywords,
                'meta_description'=>$request->meta_description
            ]);
        }
        toast(__('dashboard.updated'),'success');
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('category-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        if (($category->children)->isEmpty()){
            $category->delete();
            toast(__('dashboard.deleted'),'success');
        }
        else{
            toast(__('dashboard.deleteNotPossible'),'warning');
        }
        return redirect()->route('categories.index');

    }




    public function search(Request $request)
    {
        $categories = collect();

        if ($request->has('q')) {
            $search = $request->input('q');
            $categories = Category::select('id', 'name')
                ->where('name', 'LIKE', '%' . $search . '%')
                ->get();
        }

        $categories->push((object)['id' => 0, 'name' => 'والد']);

        return response()->json($categories);
    }
}
