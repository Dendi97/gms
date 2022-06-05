<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function __construct(private UserRepositoryContract $userRepository)
    {
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'bail|required|string',
            'email' => 'bail|required|string|unique:users,email',
            'password' => 'bail|required|string|confirmed'
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ]);
        }

        $user = $this->userRepository->registerUser([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;


        $user->update([
            'token' => $token
        ]);

        return response([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function retrieveAuthToken(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'bail|required|string|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()
            ]);
        }

        $user = $this->userRepository->getUser($request->input('email'));

        return response([
            'user' => $request->input('email'),
            'token' => $user->token
        ]);
    }
}
