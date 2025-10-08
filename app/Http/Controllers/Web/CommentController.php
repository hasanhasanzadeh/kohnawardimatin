<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $comment=new Comment();
        $comment->user_id=auth()->user()->id;
        $comment->parent_id=$request->parent_id;
        $comment->commentable_id=$request->commentable_id;
        $comment->commentable_type=$request->commentable_type;
        $comment->message=$request->description;
        $comment->save();
        toast('دیدگاه شما بعد از تایید مدیران قابل نمایش خواهد بود.','success');
        return back();
    }
}
