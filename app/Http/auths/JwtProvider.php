<?php

namespace App\Http\auths;

use Firebase\JWT\JWT;

class JwtProvider
{
    private const ALGORITHM = 'HS256';
    private const EXPIRED_TIME = 60 * 60 * 3; //3 hour
    private string $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function generate(string $user): string
    {
        $payload = ['name' => $user, 'exp' => time() + self::EXPIRED_TIME];
        return JWT::encode($payload, $this->key, self::ALGORITHM, null, null);
    }
}
