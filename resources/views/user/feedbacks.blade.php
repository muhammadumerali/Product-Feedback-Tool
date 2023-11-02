@extends('layouts.user')

@section('styles')
<style>
    .comment{
        padding: 30px;
    }
    .ck-editor__editable{
        min-height: 100px;
    }
    .activity__list__body__custom{
        padding-bottom: 10px;
        padding-left: 43px;
        border-bottom: 1px solid gainsboro;
    }
    .panel-activity__list nav{
        padding-top: 50px;
    }

    .panel-activity__list nav .leading-5{
        padding: 10px;
    }

    .panel-activity__list svg{
        height: 10px;
    }

    
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-lg-12">

        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{ trans('user.product_feedback') }}</h3>
                <div class="float-right">
                    <a href="{{ route('user.feedback.create') }}" class="btn btn-success">{{ trans('user.add_feedback') }}</a>
                    <a href="{{ route('user.logout') }}" class="btn btn-danger">{{ trans('global.logout') }}</a>
                </div>
            </div>
            <div class="panel-content panel-activity">
                <ul class="panel-activity__list">

                    @foreach($feedbacks as $key => $feedback)
                    <li>
                        <i class="activity__list__icon fa fa-question-circle-o"></i>
                        <div class="activity__list__header">
                            <img src="https://ui-avatars.com/api/?name={{ $feedback->user->name }}&background=random" alt="" />
                            <a href="javascript:void(0)">{{ $feedback->user->name }}</a> {{ trans('user.posted_the_feedback') }} <a href="#">{{ $feedback->title }}</a>
                        </div>
                        <div class="activity__list__body entry-content">
                            <p>
                               {{ $feedback->description }}
                            </p>
                        </div>
                        <div class="activity__list__footer">
                            <a href="javascript:void(0)" class="vote_feedback vote_feedback_{{ $feedback->id }} {{ $feedback->isUserVoted() ? 'text-primary' : '' }}" data-feedback_id="{{ $feedback->id }}"> <i class="fa fa-thumbs-up"></i>{{ $feedback->getVotesCount() }}</a>
                            @if($feedback->can_comment == 1)
                                <a href="javascript:void(0)" class="comments_feedback" data-feedback_id="{{ $feedback->id }}"> <i class="fa fa-comments"></i><span class="comment_count_{{ $feedback->id }}">{{ $feedback->getCommentsCount() }}</span></a>
                            @endif
                            <span> <i class="fa fa-clock"></i>{{ $feedback->getTimeSinceCreation() }}</span>
                        </div>
                        <div class="col-lg-12">
                            <div class="comment comments_feedback_{{ $feedback->id }} d-none">
                            </div>
                        </div>
                    </li>
                    @endforeach

                    {{ $feedbacks->links() }}

                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent

<script>
    $(document).on('click','.vote_feedback',function(){
        let feedback_id = $(this).attr('data-feedback_id');
        if(!feedback_id){
            alert('Error: Feedback ID not found');
            return;
        }
        LikeOrDislikeFeedback(feedback_id);
    });

    $(document).on('click','.comments_feedback',function(){
        let feedback_id = $(this).attr('data-feedback_id');
        if(!feedback_id){
            alert('Error: Feedback ID not found');
            return;
        }
        getFeedbackComments(feedback_id);
    });

    $(document).on('submit','.feedback_comment_form',function(e){
        e.preventDefault();
        let feedback_id = $(this).attr('data-feedback_id');
        let content = $('#comment_'+feedback_id).val();
        if(!feedback_id || content == ''){
            console.log('feedback ID not found or comment is empty');
            return;
        }
        saveFeedbackComment(feedback_id, content);
    });

    function saveFeedbackComment(feedback_id, content){
        $.ajax({
            headers: {'x-csrf-token': "{{ csrf_token() }}"},
            method: 'POST',
            url: "{{ route('user.comment.save') }}",
            data: {
                feedback_id: feedback_id,
                content: content
            },
            success: function(response){
               if(response.status == 1){
                getFeedbackComments(feedback_id);
                getCommentsCount(feedback_id);
               }
               else{
                alert('error saving your comment');
               }
            },
            error: function(error){
                console.log('error is ',error);
            }
        });
    }

    function getCommentsCount(feedback_id){
        $.ajax({
            method: 'GET',
            url: "{{ route('user.feedback.getcommentscount') }}",
            data: {
                feedback_id: feedback_id
            },
            success: function(response){
                if(response.status == 1){
                    $('.comment_count_'+feedback_id).html(response.count);
                }
                console.log('response is ',response);
            },
            error: function(error){
                console.log('error is ',error);
            }
        });
    }

    function getFeedbackComments(feedback_id){
        $.ajax({
            method: 'GET',
            url: "{{ route('user.feedback.getcomments') }}",
            data: {
                feedback_id: feedback_id
            },
            beforeSend: function(){
                let loading = '<img style="height: 20px;" src="https://cdn.pixabay.com/animation/2023/08/11/21/18/21-18-05-265_512.gif">';
                $('.comments_feedback_'+feedback_id).removeClass('d-none');
                $('.comments_feedback_'+feedback_id).html(loading);
            },
            success: function(response){

                $('.comments_feedback_'+feedback_id).html(response);
            },
            error: function(error){
                console.log('error is ',error);
            }
        });
    }

    function LikeOrDislikeFeedback(feedback_id){
        $.ajax({
            headers: {'x-csrf-token': "{{ csrf_token() }}"},
            method: 'POST',
            url: "{{ route('user.vote.add') }}",
            beforeSend: function(){
                $('.vote_feedback_'+feedback_id).html('loading...');
            },
            data: {
                feedback_id: feedback_id
            },
            success: function(response){
                var html = '<i class="fa fa-thumbs-up"></i>'+response.count;
                if(response.status == 1){//1 means user has disliked/disvoted the feedback
                    $('.vote_feedback_'+feedback_id).removeClass('text-primary');
                }
                else{
                    $('.vote_feedback_'+feedback_id).addClass('text-primary');
                }
                $('.vote_feedback_'+feedback_id).html(html);
            },
            error: function(error){
                console.log('error is ',error);
                $('.vote_feedback_'+feedback_id).html('<span class="text-danger">error</span>');
            }
        });
    }//end of LikeOrDislikeFeedback





</script>

@endsection