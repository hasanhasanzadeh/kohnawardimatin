<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Attribute;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProductController extends Controller
{


    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.products');
        $products = Product::query();
        if ($keyword = request('search')) {
            $products->where('title', 'LIKE', "%{$keyword}%");
        }
        $products = $products->with('photo')->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.product.index', compact(['products', 'user', 'title', 'setting']));
    }


    public function specials(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.specials');
        $products = Product::query();
        if ($keyword = request('search')) {
            $products->where('title', 'LIKE', "%{$keyword}%");
        }
        $products = $products->with('photo')->where('special',1)->whereDate('expired_at','>=',Carbon::now())->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.product.special', compact(['products', 'user', 'title', 'setting']));
    }

    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-create'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.create');
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.product.create', compact(['user', 'title', 'setting']));
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-store'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $product = new Product();
        $product->title = $request->title;
        $product->slug = Helper::makeSlug($request->slug);
        $product->sku = Helper::generateSKU();
        $product->description = $request->description;
        $product->attribute = $request->attribute;
        $product->brand_id = $request->brand_id;
        $product->photo_id = Helper::uploadImage($request->file('image'),$request->slug);
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->discount = $request->discount;
        $product->original_price = $request->original_price;
        $product->original_name= $request->original_name;
        $product->buy_price= $request->buy_price;
        $product->special= $request->special;
        $product->expired_at= $request->expired_at?$request->expired_at:null;
        $product->status = $request->status;
        $product->user_id = auth()->user()->id;
        $product->save();
        $product->categories()->sync($request->categories);
        $product->meta()->create([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);
        if ($request->has('attributes')){
            $this->attachAttributesToProduct($product, $request->validated());
        }
        if ($request->file('gallery')){
            foreach ($request->file('gallery') as $gallery){
                $path=str_replace('public','storage',$gallery->store('public/uploads'));
                $product->images()->create(['path'=>$path]);
            }
        }
        toast(__('dashboard.created'), 'success');
        return redirect()->route('products.index');
    }


    public function show($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        $product=Product::with(['images','photo','categories','meta','brand','user','attributes'])->findOrFail($id);
        return view('panel.product.show', compact(['user', 'title', 'product', 'setting']));
    }


    public function edit($id): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-edit'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.edit');
        $setting = Setting::with(['logo','favicon'])->first();
        $product=Product::with(['photo','images','categories','meta','brand','user'])->findOrFail($id);
        return view('panel.product.edit', compact(['user', 'title', 'product', 'setting']));
    }



    public function update(ProductUpdateRequest $request,$id): RedirectResponse
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $product=Product::with(['images','photo','categories','meta','brand','user'])->findOrFail($id);
        $product->title = $request->title;
//        $product->slug = Helper::makeSlug($request->slug);
        $product->description = $request->description;
        $product->attribute = $request->attribute;
        $product->brand_id = $request->brand_id;
        if ($request->file('image')){
            $product->photo_id = Helper::uploadImage($request->file('image'),$product->slug);
        }
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->discount = $request->discount;
        $product->original_price = $request->original_price;
        $product->original_name= $request->original_name;
        $product->buy_price= $request->buy_price;
        $product->status = $request->status;
        $product->special= $request->special;
        $product->expired_at = $request->expired_at?$request->expired_at:null;
        $product->user_id = auth()->user()->id;
        $product->save();

        $product->categories()->sync($request->categories);

        $product->meta()->find($product->meta->id)->update([
            'meta_title'=>$request->meta_title,
            'meta_keywords'=>$request->meta_keywords,
            'meta_description'=>$request->meta_description
        ]);

        if ($request->file('gallery')){
            $product->images()->delete();
            foreach ($request->file('gallery') as $gallery){
                $path=str_replace('public','storage',$gallery->store('public/uploads'));
                $product->images()->create(['path'=>$path]);
            }
        }

        $product->attributes()->detach();
        if ($request->has('attributes')){
            $this->attachAttributesToProduct($product, $request->validated());
        }

        toast(__('dashboard.updated'), 'success');
        return redirect()->route('products.index');
    }

    public function changeStatus(Request $request,Product $product): RedirectResponse
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        if ($request->status=='active'){
            $product->status='inactive';
            $product->save();
        }
        elseif($request->status=='inactive'){
            $product->status='soon';
            $product->save();
        }
        elseif($request->status=='soon'){
            $product->status='active';
            $product->save();
        }

        toast(__('dashboard.change_status'), 'success');
        return redirect()->route('products.index');
    }

    public function destroy($id): RedirectResponse
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('product-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        Product::findOrFail($id)->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

    /**
     * @param Product $product
     * @param array $validData
     */
    protected function attachAttributesToProduct(Product $product, array $validData): void
    {
        $attributes = collect($validData['attributes']);
        $product->attributes()->delete();
        $attributes->each(function ($item) use ($product) {
            if (is_null($item['name']) || is_null($item['value'])) return;

            $attr = Attribute::firstOrCreate(
                [
                    'name' => $item['name']
                ]
            );

            $attr_value = $attr->values()->firstOrCreate(
                [
                    'value' => $item['value'],
                    'price' => $item['price'] ?? 0
                ]
            );

            $product->attributes()->attach($attr->id, ['value_id' => $attr_value->id]);
        });
    }

}
