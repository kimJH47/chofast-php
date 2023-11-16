<?php

namespace App\Http\Controllers;

use App\Http\applications\AuthService;
use Illuminate\Http\JsonResponse;
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

    function getToken(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $tokenDto = $this->authService->getToken($body['userName'], $body['password']);
        return response()->json($tokenDto);
    }

    function signUp(Request $request): JsonResponse
    {
        $body = json_decode($request->getContent(), true);
        $id = $this->authService->signUp($body['userName'], $body['password']);
        return response()->json(['id' => $id], 201)
            ->header('Location', $request->host() . '/api/me/' . $id);
    }
}
