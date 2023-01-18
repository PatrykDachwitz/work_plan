<?php

namespace App\Http\Requests\Create;

use App\Rules\PhoneNumberValidate;
use App\Rules\ZipCodeValidate;
use Illuminate\Foundation\Http\FormRequest;

class User extends FormRequest
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            "first_name" => ['required', 'string', 'max:255'],
            "last_name" => ['string', 'max:255'],
            "email_company" => ['required', 'string', 'email', 'max:255', 'unique:users'],
            "email_private" => ['required', 'string', 'email', 'max:255', 'unique:users'],
            "number_phone" => [new PhoneNumberValidate(), 'max:12'],
            "city" => ['string', 'max:255'],
            "zip_code" => [new ZipCodeValidate(), 'max:6'],
            "street" => ['string', 'max:255'],
            "role_id" => ['string', 'max:99999999'],
            "group_id" => ['string', 'max:99999999'],
        ];
    }
}
