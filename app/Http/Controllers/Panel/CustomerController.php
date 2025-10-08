<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.customers');
        $customers = User::query();
        if($keyword = request('search')) {
            $customers->where('full_name' , 'LIKE' , "%{$keyword}%")
                ->orWhere('mobile','LIKE',"%{$keyword}%");
        }
        $customers=$customers->with('photo')->sortable()->latest()->paginate(15);
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.customer.index',compact(['title','user','customers','setting']));
    }

    public function create()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.customers');
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.customer.create',compact(['user','title','setting']));
    }


    public function store(CustomerRequest $request)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $customer=new User();
        $customer->full_name=$request->full_name;
        $customer->mobile=$request->mobile;
        $customer->email=$request->email;
        $customer->gender=$request->gender;
        $customer->birthday=$request->birthday;
        $customer->card_number=$request->card_number;
        $customer->national_code=$request->national_code;
        $customer->save();
        if ($request->file('image')){
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $customer->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.created'),'success');
        return redirect()->route('customers.index');
    }
    public function show(User $customer)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.show');
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.customer.show',compact(['user','customer','title','setting']));
    }

    public function edit(User $customer)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title=__('dashboard.edit');
        $setting=Setting::with(['favicon','logo'])->first();
        return view('panel.customer.edit',compact(['user','customer','title','setting']));
    }

    public function update(CustomerRequest $request,User $customer)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $customer->full_name=$request->full_name;
        $customer->mobile=$request->mobile;
        $customer->email=$request->email;
        $customer->gender=$request->gender;
        $customer->birthday=$request->birthday;
        $customer->card_number=$request->card_number;
        $customer->national_code=$request->national_code;
        $customer->save();
        if ($request->file('image')){
            $customer->photo?$customer->photo()->delete():null;
            $path=str_replace('public','storage',$request->file('image')->store('public/uploads'));
            $customer->photo()->create(['path'=>$path]);
        }
        toast(__('dashboard.updated'),'success');
        return redirect()->route('customers.index');
    }

    public function destroy(User $customer)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('customer-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $customer->delete();
        toast(__('dashboard.deleted'),'error');
        return redirect()->route('customers.index');
    }

    public function search(Request $request)
    {
        $users = [];
        if($request->has('q')){
            $search = $request->q;
            $users = User::select("id", "full_name","mobile",'email')->with('photo')
                ->where('full_name', 'LIKE', "%$search%")
                ->orWhere('mobile', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->get();
        }

        return response()->json($users);
    }

}
