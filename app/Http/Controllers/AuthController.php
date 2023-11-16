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
        $body = json_decode($request->getContent(), true);
        return $this->authService->getToken($body['userName'], $body['password']);
    }
}
