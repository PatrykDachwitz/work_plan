<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Rules\PhoneNumberValidate;
use App\Rules\ZipCodeValidate;
use Illuminate\Foundation\Http\FormRequest;

class UserCreate extends FormRequest
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
            "first_name" => ['required', 'string', 'max:255'],
            "last_name" => ['string', 'max:255'],
            "email_company" => ['email', 'max:255'],
            "email_private" => ['email', 'max:255'],
            "number_phone" => [new PhoneNumberValidate(), 'max:12'],
            "city" => ['string', 'max:255'],
            "zip_code" => [new ZipCodeValidate(), 'max:6'],
            "street" => ['string', 'max:255'],
        ];
    }
}
