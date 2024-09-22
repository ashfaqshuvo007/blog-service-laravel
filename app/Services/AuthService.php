<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function authorizeAndGenerateToken($data): JsonResponse
    {
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
                'access_token' => null,
            ], 401);
        }

        $token = $user->createToken($user->name .'-Auth-token', ['*'], now()->addHour())->plainTextToken;
        return response()->json([
            'message' => 'The access token was successfully generated.',
            'access_token' => $token,
        ]);
    }
}
