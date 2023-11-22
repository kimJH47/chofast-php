<?php

namespace App\Http\applications;

use JsonSerializable;

class TokenDto implements JsonSerializable
{
    private string $token;
    private string $type;
    private string $expiredTime;

    /**
     * @param string $token
     * @param string $type
     * @param string $expiredTime
     */
    public function __construct(string $token, string $type, string $expiredTime)
    {
        $this->token = $token;
        $this->type = $type;
        $this->expiredTime = $expiredTime;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getExpiredTime(): string
    {
        return $this->expiredTime;
    }




    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'type' => $this->type,
            'expiredTime' => $this->expiredTime
        ];
    }
}
