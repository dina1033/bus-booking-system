<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserLoginResource;
use App\Service\AuthService;

class AuthController extends ApiController
{
    private $auth_service;

    public function __construct(AuthService $auth_service)
    {
        $this->auth_service = $auth_service;
    }

    public function register(RegisterRequest $request)
    {
        $token = $this->auth_service->store($request->all());
        return $this->successWithData('Registration successful',$token);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->auth_service->login($request->all());
        if(!$user)
            return $this->failure('your credentials doesn\'t match our records',422);

        $token = $user->createToken('access_token')->plainTextToken;
        return $this->successWithData('Login successful', ['user'=>UserLoginResource::make($user),'access_token'=>$token], 200);
    }
}
