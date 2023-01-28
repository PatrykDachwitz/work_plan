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

    public function update(array $data, int $id)
    {
        $user = $this->findOrFail($id);

        $user->first_name = $data['first_name'] ?? $user->first_name;
        $user->email_company = $data['email_company'] ?? $user->email_company;
        $user->last_name = $data['last_name'] ?? $user->last_name;
        $user->email_private = $data['email_private'] ?? $user->email_private;
        $user->city = $data['city'] ?? $user->city;
        $user->zip_code = $data['zip_code'] ?? $user->zip_code;
        $user->street = $data['street'] ?? $user->street;
        $user->number_phone = $data['number_phone'] ?? $user->number_phone;
        $user->save();

        return $user;
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


    public function changeRole(int $id, int $role_id)
    {
        $user = $this->findOrFail($id);

        $user->role_id = $role_id;

        $user->save();

    }

    public function changeGroup(int $id, int $group_id)
    {
        $user = $this->findOrFail($id);

        $user->group_id = $group_id;

        $user->save();
    }
}