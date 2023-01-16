<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepository implements \App\Repository\UserRepository
{

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function get(array|string $column = '*') {
        return $this->user->get($column);
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

    public function findOrFail(int $id)
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
        return $this->user->create($data);
    }
}