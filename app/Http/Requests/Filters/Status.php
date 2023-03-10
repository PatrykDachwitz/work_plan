<?php

namespace App\Http\Requests\Filters;

use App\Rules\AvailableStatusDay;
use App\Rules\DataBaseTypeWhere;
use Illuminate\Foundation\Http\FormRequest;

class Status extends FormRequest
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
            'user_id' => ['integer'],
            'day_id' => ['integer'],
            'status' => [new AvailableStatusDay()],
            'accepted' => ['integer'],
            'accepted_user_id' => ['integer'],
            'date.*.value' => ['date_format:d-m-Y'],
            'date.*.type' => [new DataBaseTypeWhere()],
        ];
    }
}
