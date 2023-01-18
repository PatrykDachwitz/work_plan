<?php

namespace App\Http\Requests\Create;

use App\Rules\StringValidate;
use App\Rules\UrlValidate;
use Illuminate\Foundation\Http\FormRequest;

class Notification extends FormRequest
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
            'description' => ['required', new StringValidate(), "max:255"],
            'readed' => ['boolean'],
            'user_id' => ['required', 'integer'],
            'author_id' => ['required', 'integer'],
            'url_action' => ['required', new UrlValidate(), "max:255"],
        ];
    }
}
