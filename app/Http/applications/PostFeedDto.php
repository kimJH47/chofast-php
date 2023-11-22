<?php
namespace App\Http\applications;

use JsonSerializable;

class PostFeedDto implements JsonSerializable
{
    private array $posts;
    private int $lastId;

    /**
     * @param array $posts
     * @param int $lastId
     */
    public function __construct(array $posts, int $lastId)
    {
        $this->posts = $posts;
        $this->lastId = $lastId;
    }

    public function getPosts(): array
    {
        return $this->posts;
    }



    public function jsonSerialize(): array
    {
        return [
            'posts' => $this->posts,
            'lastId' => $this->lastId
        ];
    }
}
