<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Vote;
use Auth;

class VoteController extends Controller
{
    public function create()
    {
        //abort_if(Gate::denies('feedback_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('user.feedbacks.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        $feedback_id = $request->feedback_id;
        $exist = Vote::where('user_id', $user_id)->where('feedback_id', $feedback_id)->first();
        $response = array();
        if($exist){ //this means user is dislikeing or disvoting
            Vote::where('user_id', $user_id)->where('feedback_id', $feedback_id)->delete();
            $response['status'] = 1;
        }
        else{//this means user is voting
            Vote::create(['user_id' => $user_id, 'feedback_id' => $feedback_id]);
            $response['status'] = 0;
        }
        $response['count'] = Vote::where('user_id', $user_id)->where('feedback_id', $feedback_id)->count();
        return response()->json($response);
    }
}
