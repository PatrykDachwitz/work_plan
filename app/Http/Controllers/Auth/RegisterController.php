<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\PhoneNumberValidate;
use App\Rules\ZipCodeValidate;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
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
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User();

        $user->password = Hash::make($data['password']);
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'] ?? null;
        $user->email_company = $data['email_company'];
        $user->email_private = $data['email_private'];
        $user->number_phone = $data['number_phone'] ?? null;
        $user->city = $data['city'] ?? null;
        $user->zip_code = $data['zip_code'] ?? null;
        $user->street = $data['street'] ?? null;
        $user->role_id = $data['role_id'] ?? 0;
        $user->group_id = $data['group_id'] ?? 0;
        $user->token_api = uniqid();
        $user->save();

        return $user;
    }
}
