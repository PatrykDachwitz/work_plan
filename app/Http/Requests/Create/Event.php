<?php

namespace App\Http\Requests\Create;

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
            'date' => ['required', "date_format:d-m-Y"],
            'hour' => ['required', "date_format:H:i"],
            'user_id' => ['required', 'min:1', 'integer'],
            'status_id' => ['nullable', 'integer'],
            'description' => [new StringValidate(), 'max:255'],
            'exitWork' => ['boolean'],
            'startWork' => ['boolean'],
        ];
    }
}
