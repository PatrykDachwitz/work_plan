<?php

namespace App\Http\Requests\Filters;

use App\Rules\StringValidate;
use Illuminate\Foundation\Http\FormRequest;

class Event extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'date' => ["date_format:Y-m-d H:i:s"],
            'user_id' => ['integer'],
            'description' => [new StringValidate(), 'max:255'],
        ];
    }
}
