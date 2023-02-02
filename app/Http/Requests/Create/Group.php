<?php

namespace App\Http\Requests\Create;

use App\Rules\StringValidate;
use Illuminate\Foundation\Http\FormRequest;

class Group extends FormRequest
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
            'name' => ['required', new StringValidate(), "max:255"],
            'available' => ['required', 'boolean']
        ];
    }
}
