<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Rules\AvailableStatusDay;
use Illuminate\Foundation\Http\FormRequest;

class StatusCreate extends FormRequest
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
            'time_start' => ['date_format:Y-m-d H:i:s'],
            'time_end' => ['date_format:Y-m-d H:i:s'],
            'day_end' => ['date_format:d-m-Y'],
            'day_start' => ['date_format:d-m-Y'],
            'status' => ['required', new AvailableStatusDay()],
        ];
    }
}
