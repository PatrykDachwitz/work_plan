<?php

namespace App\Repository;

interface UserApi
{
    public function findByToken(string $token);
    public function findOrFail(array|int $id);
}