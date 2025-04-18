<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class NewTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['string', 'max:100', 'required'],
            'description' => ['string']
        ];
    }
}
