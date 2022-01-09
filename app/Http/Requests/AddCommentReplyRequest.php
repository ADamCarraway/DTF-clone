<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentReplyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comment'   => 'required',
            'id'        => 'exists:posts',
            'commentId' => 'exists:comments,id',
        ];
    }
}
