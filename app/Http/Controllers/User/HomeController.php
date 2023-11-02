<?php

namespace App\Http\Controllers\User;
use App\Models\Feedback;

class HomeController
{
    public function index()
    {
        $feedbacks = Feedback::orderBy('id','DESC')->paginate(10);
        return view('user.feedbacks',compact('feedbacks'));
    }
}