<?php

namespace App\Http\Requests;

use App\Contracts\Likeable;
use App\Contracts\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class NotificationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'notifiable' => ["required", "string", function ($attribute, $value, $fail) {
                $class = $this->getClass($value);

                if (!class_exists($class, true)) {
                    $fail($value . " is not a valid class");
                }

                if (!in_array(Model::class, class_parents($class))) {
                    $fail($value . " is not a model");
                }

                if (!in_array(Notifiable::class, class_implements($class))) {
                    $fail($value . " is not a notifiable");
                }
            },
            ],
            'id' => [
                "required",
                function ($attribute, $value, $fail) {
                    $class = $this->getClass($this->input('notifiable'));

                    if (!$class::where('id', $value)->exists()) {
                        $fail($value . " is not present in database");
                    }
                },
            ],
        ];
    }

    public function notifiable(): Notifiable
    {
        $class = $this->getClass($this->input('notifiable'));

        return $class::findOrFail($this->input('id'));
    }

    protected function getClass($value): string
    {
        return "App\Models\\" . Str::studly($value);
    }
}
