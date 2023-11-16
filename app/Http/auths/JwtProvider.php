<?php

namespace App\Http\auths;

use App\Http\applications\TokenDto;
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

    public function generate(string $user): TokenDto
    {
        $payload = ['name' => $user, 'exp' => time() + self::EXPIRED_TIME];
        return new TokenDto(JWT::encode($payload, $this->key, self::ALGORITHM), "Bearer", self::EXPIRED_TIME);
    }
}
