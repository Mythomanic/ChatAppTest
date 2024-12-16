<?php
// app/Repositories/UserRepository.php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserRepository implements IUserRepository
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function loginUser(string $email, string $password)
    {
        $user = $this->model
            ->where('email', $email)
            ->where('password', Hash::make($password))
            ->first();

        if ($user && Hash::check($password, $user->password)) {
            $userToken = Uuid::uuid4()->toString();

            $user->userToken = $userToken;

            return $user;
        }

        return null;
    }

    public function registerUser(array $data)
    {
        $user = $this->model->create($data);

        if ($user) {
            return $user;
        }

        return null;
    }

}
