<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request, UserService $userService)
    {
        return UserResource::make(User::find($userService->store($request->validated())->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, UserService $userService)
    {
        return $userService->deleteUser($id);
    }

    /**
     * @param LoginRequest $request
     * @param AuthService $authService
     * @return JsonResponse
     */
    public function login(LoginRequest $request, AuthService $authService)
    {
        return $authService->authorizeAndGenerateToken($request->validated());
    }
}
