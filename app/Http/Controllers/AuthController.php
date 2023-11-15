<?php

namespace App\Http\Controllers;

use App\Http\applications\AuthService;
use App\Http\auths\JwtProvider;
use Illuminate\Http\Request;

class AuthController
{
    private AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    function getToken(Request $request): string
    {
        $body = $request->getContent();
        return $this->authService->getToken($body['userName'], $body['password']);
    }
}
