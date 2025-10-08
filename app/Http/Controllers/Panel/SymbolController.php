<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\SymbolRequest;
use App\Http\Requests\SymbolUpdateRequest;
use App\Models\Setting;
use App\Models\Symbol;
use App\Models\User;


class SymbolController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.symbols');
        $symbols= Symbol::query();
        if ($keyword = request('search')) {
            $symbols->where('title', 'LIKE', "%{$keyword}%");
        }
        $symbols = $symbols->with(['setting'])->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.symbol.index', compact(['symbols', 'user', 'title', 'setting']));

    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.symbol');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.symbol.create',compact(['user','title','setting']));
    }

    public function store(SymbolRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $symbol=new Symbol();
        $symbol->setting_id=$request->setting_id;
        $symbol->title=$request->title;
        $symbol->url=$request->url;
        $symbol->description=$request->description;
        $symbol->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $symbol->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.created'),'success');
        return redirect()->route('symbols.index');
    }

    public function show($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $symbol=Symbol::with(['photo','setting'])->findOrFail($id);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.symbol.show',compact(['user','symbol','title','setting']));
    }


    public function edit($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $symbol=Symbol::with(['photo','setting'])->findOrFail($id);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.symbol.edit',compact(['user','symbol','title','setting']));
    }


    public function update(SymbolUpdateRequest $request, $id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $symbol=Symbol::findOrFail($id);
        $symbol->setting_id=$request->setting_id;
        $symbol->title=$request->title;
        $symbol->url=$request->url;
        $symbol->description=$request->description;
        $symbol->save();
        if ($request->file('image')){
            $symbol->photo?$symbol->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $symbol->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'),'success');
        return redirect()->route('symbols.index');
    }

    public function destroy($id)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('symbol-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        Symbol::findOrFail($id)->delete();
        toast(__('dashboard.deleted'),'success');
        return redirect()->route('symbols.index');
    }
}
