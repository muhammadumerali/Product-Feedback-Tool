<form action="" method="POST" data-feedback_id="{{ $feedback_id }}" class="feedback_comment_form">
    @csrf

    <div class="form-group">
        <textarea class="form-control ckeditor" id="comment_{{ $feedback_id }}"></textarea>
    </div>
    <div class="float-right">
        <button class="btn btn-primary">{{ trans('user.comment') }}</button>
    </div>
</form>

<ul class="panel-activity__list">
    @foreach($comments as $key => $comment)
        <li>
            <i class="activity__list__icon fa fa-question-circle-o"></i>
            <div class="activity__list__header">
                <img src="https://ui-avatars.com/api/?name=Jhon&background=random" alt="" /> <span>{{ $comment->user->name }}</span>
            </div>
            <div class="activity__list__body__custom  entry-content">
                <p>
                    {!! $comment->content !!}
                </p>
            </div>
        </li>
    @endforeach
</ul>

<script>
    ClassicEditor
        .create(document.querySelector('#comment_{{ $feedback_id }}'))
        .catch(error => {
            console.error(error);
        });
</script>