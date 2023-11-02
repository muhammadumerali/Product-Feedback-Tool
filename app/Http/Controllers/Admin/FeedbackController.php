<?php

namespace App\Http\Controllers\Admin;

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

class FeedbackController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('feedback_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedbacks = Feedback::with(['user', 'category'])->get();

        $users = User::get();

        $categories = Category::get();

        return view('admin.feedbacks.index', compact('categories', 'feedbacks', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('feedback_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.feedbacks.create', compact('categories', 'users'));
    }

    public function store(StoreFeedbackRequest $request)
    {
        $feedback = Feedback::create($request->all());

        return redirect()->route('admin.feedbacks.index');
    }

    public function edit(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::pluck('category', 'id')->prepend(trans('global.pleaseSelect'), '');

        $feedback->load('user', 'category');

        return view('admin.feedbacks.edit', compact('categories', 'feedback', 'users'));
    }

    public function update(UpdateFeedbackRequest $request, Feedback $feedback)
    {
        $feedback->update($request->all());

        return redirect()->route('admin.feedbacks.index');
    }

    public function show(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedback->load('user', 'category');

        return view('admin.feedbacks.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        abort_if(Gate::denies('feedback_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $feedback->delete();

        return back();
    }

    public function massDestroy(MassDestroyFeedbackRequest $request)
    {
        $feedbacks = Feedback::find(request('ids'));

        foreach ($feedbacks as $feedback) {
            $feedback->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
