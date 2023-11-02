<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFeedbackRequest;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Comment;

class FeedbackController extends Controller
{
    public function create()
    {
        $categories = Category::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('user.feedbacks.create',compact('categories'));
    }

    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->all());

        return redirect()->route('user.home');
    }

    public function comments(Request $request){
        $feedback_id = $request->feedback_id;
        if(!$feedback_id){
            return '';
        }
        $comments = Comment::where('feedback_id', $feedback_id)->orderBy('id','DESC')->get();
        $html = view('user.feedbacks.comments',compact('comments','feedback_id'))->render();
        return $html;
    }

    public function getCommentsCount(Request $request){
        $feedback_id = $request->feedback_id;
        $response = array();
        if(!$feedback_id){
            $response['status'] = 0;
        }
        else{
            $response['status'] = 1;
            $response['count'] = Comment::where('feedback_id', $feedback_id)->count();
        }
        return response()->json($response);
    }
}
