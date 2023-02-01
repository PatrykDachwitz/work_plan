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
            'status' => [new AvailableStatusDay()],
            'token_api' => ['string'],
            'accepted' => ['boolean'],
            'hour_end' => ['date_format:H:i'],
            'hour_start' => ['date_format:H:i'],
        ];
    }
}
