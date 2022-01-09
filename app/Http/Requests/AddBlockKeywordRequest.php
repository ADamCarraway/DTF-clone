<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddBlockKeywordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'keyword' => ['required', Rule::unique('ignored_keywords')
                ->where(function ($query) {
                    return $query->where('keyword', $this->keyword)
                        ->where('user_id', $this->user()->id);
                })]
        ];
    }
}
