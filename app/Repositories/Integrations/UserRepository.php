<?php


namespace App\Repositories\Integrations;


use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryContract
{

    public function __construct(private User $model) {}

    public function registerUser(array $userDetails): Model
    {
        return $this->model::create($userDetails);
    }

    public function getUser(string $email): ?Model
    {
        return $this->model::where('email', $email)->first();
    }
}
