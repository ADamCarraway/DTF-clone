<?php

namespace App\Http\Requests;

use App\Contracts\Ignorable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class IgnoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ignorable' => ["required", "string", function ($attribute, $value, $fail) {
                $class = $this->getClass($value);

                if (!class_exists($class, true)) {
                    $fail($value . " is not a valid class");
                }

                if (!in_array(Model::class, class_parents($class))) {
                    $fail($value . " is not a model");
                }

                if (!in_array(Ignorable::class, class_implements($class))) {
                    $fail($value . " is not a ignorable");
                }
            },
            ],
            'id' => [
                "required",
                function ($attribute, $value, $fail) {
                    $class = $this->getClass($this->input('ignorable'));

                    if (!$class::where('id', $value)->exists()) {
                        $fail($value . " is not present in database");
                    }
                },
            ],
        ];
    }

    public function ignorable(): Ignorable
    {
        $class = $this->getClass($this->input('ignorable'));

        return $class::findOrFail($this->input('id'));
    }

    protected function getClass($value): string
    {
        return "App\\" . Str::studly($value);
    }
}
