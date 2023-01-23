<?php
declare(strict_types=1);
namespace App\Http\Requests\Create;

use App\Rules\AvailableStatusDay;
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
            'user_id' => ['required', 'integer', 'min:1', "max:99999999"],
            'day_id' => ['integer', 'min:1', "max:99999999"],
            'status' => ['required', new AvailableStatusDay()],
            'hour_start' => ['nullable', 'date_format:H:i'],
            'hour_end' => ['nullable', 'date_format:H:i'],
            'date' => ['required', 'date_format:d-m-Y'],
            'complety_time' => ['integer'],
        ];
    }
}
