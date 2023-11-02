<?php

namespace App\Http\Requests;

use App\Models\Feedback;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('feedback_create');
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer',
            ],
            'category_id' => [
                'required',
                'integer',
            ],
            'title' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'required',
            ],
        ];
    }
}
