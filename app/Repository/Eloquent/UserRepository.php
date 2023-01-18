<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserApi;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;

class UserRepository implements \App\Repository\UserRepository, UserApi
{

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function get(array|string $column = '*') {
        return $this->user
            ->with('relationStatus')
            ->get($column);
    }

    public function update(array $data, User $updateUser)
    {

        $updateUser->first_name = $data['first_name'] ?? $updateUser->first_name;
        $updateUser->email_company = $data['email_company'] ?? $updateUser->email_company;
        $updateUser->last_name = $data['last_name'] ?? $updateUser->last_name;
        $updateUser->email_private = $data['email_private'] ?? $updateUser->email_private;
        $updateUser->city = $data['city'] ?? $updateUser->city;
        $updateUser->zip_code = $data['zip_code'] ?? $updateUser->zip_code;
        $updateUser->street = $data['street'] ?? $updateUser->street;
        $updateUser->number_phone = $data['number_phone'] ?? $updateUser->number_phone;
        $updateUser->save();

        return $updateUser->id;
    }

    public function findOrFail(array|int $id)
    {
        try {
            return $this->user->findOrFail($id);
        } catch (ModelNotFoundException) {
            abort(404);
        } catch (Exception) {
            abort(505);
        }
    }

    public function create(array $data)
    {
        $user = new $this->user();

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

    public function findByToken(string $token)
    {
        $user = $this->user
        ->where('token_api', $token)
        ->first();
        if (is_null($user)) throw new ModelNotFoundException();
        else return $user;
    }
}