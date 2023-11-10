<?php

namespace App\Http\applications;

use App\Http\daos\PostDao;

class PostService
{
    private PostDao $postDao;

    /**
     * @param PostDao $postDao
     */
    public function __construct(PostDao $postDao)
    {
        $this->postDao = $postDao;
    }

    public function findOne(string $id): PostDto
    {
        $post = $this->postDao->findOneById($id);
        return PostDto::create($post);
    }
}
