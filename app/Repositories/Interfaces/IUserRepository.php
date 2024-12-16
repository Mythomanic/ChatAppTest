<?php

namespace App\Repositories\Interfaces;

interface IUserRepository
{
    public function loginUser(string $email, string $password);
    public function registerUser(array $data);
}
