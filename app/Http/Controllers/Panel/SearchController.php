<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Search;
use App\Models\Setting;
use App\Models\User;

class SearchController extends Controller
{


    public function index()
    {
        $user=User::with('photo')
            ->findOrFail(auth()->user()->id);
        if (! $user->can('search-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.search');
        $searches = Search::query();
        if ($keyword = request('search')) {
            $searches->withTrashed()->with(['user'])
                ->where('search_text', 'LIKE', "%{$keyword}%")
                ->orWhere('ip_address', 'LIKE', "%{$keyword}%")
                ->orWhereHas('user',function ($query)use($keyword){
                   $query->where('full_name','like',"%{$keyword}%")
                   ->orWhere('mobile','like',"%{$keyword}%")
                   ->orWhere('mail','like',"%{$keyword}%");
                });
        }
        $searches = $searches
            ->withTrashed()
            ->with(['user'])
            ->sortable()->latest()
            ->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.search.index',
            compact(['searches', 'user', 'title', 'setting']));
    }

    public function destroy($id)
    {
        $user=User::with('photo')
            ->findOrFail(auth()->user()->id);
        if (! $user->can('search-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        Search::withTrashed()->findOrFail($id)->forceDelete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

}
