@foreach($comments as $comment)
    <li>
    <div class="comment-body">
        <div class="comment-author">
            @if($comment->user->photo_id)
                <img alt="" src="{{$comment->user?->photo->address}}" class="avatar">
            @else
                <img alt="" src="{{asset('assets/img/default-avatar.png')}}" class="avatar">
            @endif
            <cite class="fn">{{$comment->user->name}}</cite>

            <span class="says">گفت:</span>
        </div>

        <div class="commentmetadata">
            <a href="#">
                {{verta()->instance($comment->created_at)->format('%d %B %Y')}}
            </a>
        </div>

        <p>{!! $comment->body !!}</p>

        <div class="reply">
            <a class="comment-reply-link" data-toggle="modal" data-target="#sendCommentModal" data-parent="{{ $comment->id }}">پاسخ</a>
        </div>
    </div>
</li>
    @if($comment->comments)
        @include('layouts.comment',['subject'=>$comment->comments])
    @endif
@endforeach

<li>
    {{$comments->links()}}
</li>

<div class="modal fade" id="sendCommentModal" tabindex="-1" role="dialog" aria-labelledby="sendCommentModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="exampleModalLabel">ارسال پاسخ</h4>
            </div>
            <div class="modal-body">
                <form action="{{route('comments.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="parent_id" value="0">
                    <input type="hidden" name="commentable_id" value="{{ $subject->id }}">
                    <input type="hidden" name="commentable_type" value="{{ get_class($subject) }}">
                    <div class="col-12">
                        <div  class="form-account-title">متن پیام <span class="text-danger">*</span></div>
                        <div class="form-account-row">
                         <textarea class="input-field" id="message-text" name="description">{{old('description')}}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">ارسال</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
