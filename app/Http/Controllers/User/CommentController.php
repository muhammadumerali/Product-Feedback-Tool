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
use Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();
        $data['date'] = date('Y-m-d');
        $data['user_id'] = Auth::user()->id;
        $comment = Comment::create($data);
        if($comment){
            return response()->json(['status' => 1]);
        }
        else{
            return response()->json(['status' => 0]);
        }
    }
}
