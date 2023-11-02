<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VoteController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('vote_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $votes = Vote::with(['feedback', 'user'])->get();

        return view('admin.votes.index', compact('votes'));
    }
}
