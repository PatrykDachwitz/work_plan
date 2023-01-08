<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Rules\DayName;
use Illuminate\Foundation\Http\FormRequest;

class DayUpdate extends FormRequest
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
            'date' => ['date_format:d-m-Y', "max:255"],
            'day_name' => [new DayName(), "max:255"],
            'free_day' => ['boolean'],
        ];
    }
}
