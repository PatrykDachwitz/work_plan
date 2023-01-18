<?php

namespace App\Http\Requests\Filters;

use App\Rules\DataBaseTypeWhere;
use App\Rules\DayName;
use Illuminate\Foundation\Http\FormRequest;

class Day extends FormRequest
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
            'date.*.value' => ['date_format:d-m-Y', "max:255"],
            'date.*.type' => [new DataBaseTypeWhere()],
            'day_name.value' => [new DayName()],
            'day_name.type' => [new DataBaseTypeWhere()],
            'free_day.value' => ['boolean'],
            'free_day.type' => [new DataBaseTypeWhere()],
        ];
    }
}
