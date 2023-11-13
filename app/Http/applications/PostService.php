<?php

namespace App\Http\applications;

use App\Exceptions\CustomException;
use App\Http\daos\PostDao;
use App\Http\daos\UserDao;

class PostService
{
    private PostDao $postDao;
    private UserDao $userDao;

    /**
     * @param PostDao $postDao
     * @param UserDao $userDao
     */
    public function __construct(PostDao $postDao, UserDao $userDao)
    {
        $this->postDao = $postDao;
        $this->userDao = $userDao;
    }

    public function findOne(string $id): PostDto
    {
        $post = $this->postDao->findOneById($id);
        return PostDto::create($post);
    }

    public function save(SavePostDto $savePostDto): int
    {
        $this->validateUser($savePostDto->getUserName());
        return $this->postDao->save(
            $savePostDto->getContent(),
            $savePostDto->getUserName()
        );
    }

    /**
     * @throws CustomException
     */
    private function validateUser(string $userName): void
    {
        if (!$this->userDao->existsUser($userName)) {
            throw new CustomException("user not found");
        }
    }

    public function findByRecently(int $index): array
    {
        $posts = $this->postDao->findAllWithPageOrderByRecently($index);
        return array_map(function ($post) {
            return PostDto::create($post);
        }, $posts);
    }
}
