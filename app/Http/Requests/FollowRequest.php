<?php

namespace App\Http\Requests;

use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FollowRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'followable' => ["required", "string", function ($attribute, $value, $fail) {
                $class = $this->getClass($value);

                if (!class_exists($class, true)) {
                    $fail($value . " is not a valid class");
                }

                if (!in_array(Model::class, class_parents($class))) {
                    $fail($value . " is not a model");
                }

                if (!in_array(CanBeFollowedContract::class, class_implements($class))) {
                    $fail($value . " is not a followable");
                }
            },
            ],
            'id' => [
                "required",
                function ($attribute, $value, $fail) {
                    $class = $this->getClass($this->input('followable'));

                    if (!$class::where('id', $value)->exists()) {
                        $fail($value . " is not present in database");
                    }
                },
            ],
        ];
    }

    public function followable(): CanBeFollowedContract
    {
        $class = $this->getClass($this->input('followable'));

        return $class::findOrFail($this->input('id'));
    }

    protected function getClass($value): string
    {
        return "App\\" . Str::studly($value);
    }
}
