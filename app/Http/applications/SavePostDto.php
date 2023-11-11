<?php

namespace App\Http\applications;

class SavePostDto
{
    private string $content;
    private string $userName;

    /**
     * @param string $content
     * @param string $userName
     */
    public function __construct(string $content, string $userName)
    {
        $this->content = $content;
        $this->userName = $userName;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public static function create(string $body): SavePostDto
    {
        $body = json_decode($body, true);
        return new SavePostDto($body['content'], $body['userName']);
    }

}
