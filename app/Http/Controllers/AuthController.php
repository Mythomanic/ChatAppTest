<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
class AuthController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $this->userRepository->loginUser(
            $validate['email'],
            $validate['password']
        );

        if (!$user) {
            return response()->json([
                'result' => 'failed',
                'message' => 'Invalid credentials',
            ], 422);
        }

        return response()->json([
            'result' => 'success',
            'message' => 'Login successful',
            'data' => $user,
        ], 201);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'passwordConfirmation' => 'required',
        ]);

        $registerCheck = $this->userRepository->registerUser($validate);

        if (!$registerCheck) {
            return response()->json([
                'result' => 'failed',
                'message' => 'Registration failed',
            ], 422);
        }

        return response()->json([
            'result' => 'success',
            'message' => 'Registration successful',
            'data' => $registerCheck,
        ], 201);
    }






}

