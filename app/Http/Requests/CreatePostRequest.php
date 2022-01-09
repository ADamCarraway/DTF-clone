<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id'         => 'nullable|exists:posts',
            'title'      => 'string|nullable',
            'intro'      => 'string|nullable',
            'blocks'     => 'array|nullable',
            'is_publish' => 'in:0,1'
        ];
    }
}
