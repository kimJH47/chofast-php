<?php

namespace App\Http\applications;

use App\Http\models\Post;
use JsonSerializable;

class PostDto implements JsonSerializable
{
    private string $id;
    private string $content;

    private string $userName;

    /**
     * @param string $id
     * @param string $content
     * @param string $userName
     */
    public function __construct(string $id, string $content, string $userName)
    {
        $this->id = $id;
        $this->content = $content;
        $this->userName = $userName;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public static function create(Post $post): PostDto
    {
        return new PostDto($post->getId(), $post->getContent(), $post->getUserName());
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'userName' => $this->userName
        ];
    }
}
