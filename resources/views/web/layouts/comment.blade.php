@foreach($subject as $comment_ab)
    <ol class="children">
        <li>
            <div class="comment-body">
                <div class="comment-author">
                    @if($comment_ab->user->photo_id)
                    <img alt="" src="{{$comment_ab->user?->photo->address}}" class="avatar">
                    @else
                    <img alt="" src="{{asset('assets/img/default-avatar.png')}}" class="avatar">
                    @endif
                    <cite class="fn">{{$comment_ab->user->name}}</cite>
                    <span class="says">گفت:</span>
                </div>

                <div class="commentmetadata">
                    <a href="#">
                        {{verta()->instance($comment_ab->created_at)->format('%d %B %Y')}}
                    </a>
                </div>

                <p>
                    {!! $comment_ab->body !!}
                </p>

                <div class="reply">
                    <a class="comment-reply-link" data-toggle="modal" data-target="#sendCommentModal" data-parent="{{ $comment_ab->id }}">پاسخ</a>
                </div>
            </div>
        @if($comment_ab->comments)
            @include('layouts.comment',['subject'=>$comment_ab->comments])
        @endif
            <!-- .children -->
        </li>
        <!-- #comment-## -->

    </ol>
@endforeach
