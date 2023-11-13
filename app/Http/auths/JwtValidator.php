<?php

namespace App\Http\auths;

use App\Exceptions\CustomException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtValidator
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @throws CustomException
     */
    public function validateToken(string $token): void
    {
        try {
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
        } catch (Exception $exception) {
            throw new CustomException($exception->getMessage());
        }
    }
}
