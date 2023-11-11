<?php

namespace App\Http\models;

class Post
{
    private int $id;
    private string $content;
    private string $createdAt;
    private string $userName;

    /**
     * @param int $id
     * @param string $content
     * @param string $createdAt
     * @param string $userName
     */
    public function __construct(int $id, string $content, string $createdAt, string $userName)
    {
        $this->id = $id;
        $this->content = $content;
        $this->createdAt = $createdAt;
        $this->userName = $userName;
    }

    public function getId(): int
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

    public static function createWithModel($model): Post
    {
        return new Post($model->id, $model->content, $model->created_at, $model->user_name);
    }
}
