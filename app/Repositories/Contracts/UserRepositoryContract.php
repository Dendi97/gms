<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface UserRepositoryContract
{

    public function registerUser(array $userDetails): Model;

    public function getUser(string $email): ?Model;

}
