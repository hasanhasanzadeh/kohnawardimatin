<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AttributeController extends Controller
{
    public function __invoke(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $data = $request->validate([
            'name' => 'required'
        ]);

        $attr = Attribute::where('name' , $data['name'])->first();
        if(is_null($attr))
            return response([ 'data' => []]);

        return response([ 'data' => $attr->values->pluck('value') ]);
    }
}
