<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Feedback;

class HomeController
{
    public function index()
    {
        $users = User::count();
        $feedbacks = Feedback::count();
        return view('home',compact('users','feedbacks'));
    }
}
