<?php

namespace App\Http\Controllers\Panel;

use App\Events\MsgSendText;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentSaveRequest;
use App\Mail\DefaultMail;
use App\Mail\ProductSendLinkEmail;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class CommentController extends Controller
{


    public function index()
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('comment-all'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.comments');
        $comments = Comment::query();
        if ($keyword = request('search')) {
            $comments->where('title', 'LIKE', "%{$keyword}%");
        }
        $comments = $comments->with('comments')->sortable()->latest()->paginate(20);
        $setting = Setting::with(['favicon','logo'])->first();
        return view('panel.comment.index', compact(['comments', 'user', 'setting','title']));
    }


    public function show(Comment $comment)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('comment-find'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.show');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.comment.show', compact(['user', 'title', 'comment', 'setting']));
    }

    public function answerShow(Comment $comment)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('comment-answer'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $title = __('dashboard.answer');
        $setting = Setting::with(['logo','favicon'])->first();
        return view('panel.comment.answer', compact(['user', 'title', 'comment', 'setting']));
    }

    public function answerSave(CommentSaveRequest $request,Comment $comment)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('comment-answer'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $commentable=new Comment();
        $commentable->parent_id=$request->parent_id;
        $commentable->user_id=$user->id;
        $commentable->status=$request->status;
        $commentable->message=$request->message;
        $commentable->commentable_id=$comment->user_id;
        $commentable->commentable_type="App\Models\User";
        $commentable->save();

        $comment->status=$request->status;
        $comment->save();
        $customer=User::find($comment->user_id);
        $product_link=url('/');
        if ($comment->user->mobile){
            event(new MsgSendText($customer,$product_link));
        }else{
            $setting = Setting::with(['favicon','logo','meta','medias','symbols'])->first();
            $details=[
                'link'=>$product_link,
                'full_name'=>$comment->user->full_name,
                'subject'=>__('front.comment')
            ];
            Mail::to($user->email)->send(new DefaultMail($details,$setting));
        }
        toast(__('dashboard.commentSaved'), 'success');
        return redirect()->route('comments.index');
    }


    public function destroy(Comment $comment)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('comment-delete'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $comment->delete();
        toast(__('dashboard.deleted'), 'success');
        return redirect()->back();
    }

    public function changeStatus(Comment $comment)
    {
        $user=User::with('photo')->findOrFail(auth()->user()->id);
        if (! $user->can('comment-update'))
        {
            abort(403,__('dashboard.accessDenied'));
        }
        $comment->status=!$comment->status;
        $comment->save();
        toast(__('dashboard.change_status'), 'success');
        return redirect()->back();
    }

}
