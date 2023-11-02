<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCommentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('comment_edit');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'feedback_id' => [
                'required',
                'integer',
            ],
            'date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'content' => [
                'required',
            ],
        ];
    }
}
