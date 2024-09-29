<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function store(array $data)
    {
        // TODO: User create 'username' gets null always
        $data = array_merge([
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10)
        ], $data);

        return User::create($data);

    }

    public function deleteUser($id): JsonResponse
    {
        if(empty(User::destroy($id))) {
            return response()->json([
                'message' => 'Delete operation failed',
            ]);
        }

        return response()->json([
            'message' => 'Delete operation succeeded',
        ]);

    }

}
