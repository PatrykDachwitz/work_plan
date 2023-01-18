<?php
declare(strict_types=1);
namespace App\Http\Requests\Update;

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
            'time_start' => ['date_format:Y-m-d H:i:s'],
            'time_end' => ['date_format:Y-m-d H:i:s'],
            'status' => [new AvailableStatusDay()],
            'token_api' => ['required', 'string'],
            'accepted' => ['boolean'],
            'accepted_user_id' => ['integer', "min:1", "max:99999999"],
        ];
    }
}
