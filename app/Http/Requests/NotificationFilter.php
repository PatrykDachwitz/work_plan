<?php

namespace App\Http\Requests;

use App\Rules\StringValidate;
use App\Rules\UrlValidate;
use Illuminate\Foundation\Http\FormRequest;

class NotificationFilter extends FormRequest
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
            'description' => [new StringValidate(), "max:255"],
            'readed' => ['boolean'],
            'url_action' => [new UrlValidate(), "max:255"],
            'user_id' => ['integer'],
            'author_id' => ['integer'],
        ];
    }
}
