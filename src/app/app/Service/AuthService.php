<?php

namespace App\Service;

use App\Repository\AuthRepositoryInterface;
use App\Service\BaseService;
use Illuminate\Support\Facades\Hash;

class AuthService extends BaseService
{
    protected $repo;
    public function __construct(AuthRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    function store(array $data)
    {
        $user = $this->repo->create([
            'name' => $data['name'],
            'mobile_number' => $data['mobile_number'] ,
            'email' => $data['email'] ,
            'password' => Hash::make($data['password']),
        ]);

        return $user->createToken('access_token')->plainTextToken;
    }

    function login(array $data){
         $user = $this->repo->getByEmail($data['email']);
         if ($user && Hash::check($data['password'], $user->password)) {
             return $user;
         }
         return false;

    }
}
