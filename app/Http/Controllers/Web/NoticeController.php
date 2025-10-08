<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    public function addNotice(Request $request,$id)
    {
        if (auth()->check()){
            $notice=Notice::where('user_id',auth()->user()->id)->where('product_id',$id)->first();
            if(empty($notice)){
                $notice_a=new Notice();
                $notice_a->user_id=auth()->user()->id;
                $notice_a->product_id=$id;
                $notice_a->save();
                $notice_a->products()->attach($id);
                toast('محصول مورد نظر به محض موجود بودن به از طریق پیامک به شما اطلاع داده می شود.','success');
                return back();
            }
            else{
                $notice->status=0;
                $notice->save();
                toast('محصول مورد نظر در لیست اطلاع شما می باشد و به محض موجود بودن از طریق پیامک به شما اطلاع رسانی می شود.','error');
                return back();
            }
        }
        return redirect('/login');

    }
}
