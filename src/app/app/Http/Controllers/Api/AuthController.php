<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Api\UserLoginResource;
use App\Service\AuthService;

class AuthController extends ApiController
{
    private $authservice;

    public function __construct(AuthService $authservice)
    {
        $this->authservice = $authservice;
    }

    public function register(RegisterRequest $request)
    {
        $token = $this->authservice->store($request->all());
        return $this->successWithData('you have been registered successfully',$token);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authservice->login($request->all());
        if(!$user)
            return $this->failure('your credentials doesn\'t match our records',422);

        $token = $user->createToken('access_token')->plainTextToken;
        return $this->successWithData('تم الدخول بنجاح', ['user'=>UserLoginResource::make($user),'access_token'=>$token], 200);
    }
}
