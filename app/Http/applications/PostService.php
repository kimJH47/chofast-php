<?php

namespace App\Http\applications;

use App\Exceptions\CustomException;
use App\Http\daos\PostDao;
use App\Http\daos\UserDao;
use App\Http\models\Post;

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

    public function findOne(int $id): PostDto
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

    public function findByRecently(int $lastId): PostFeedDto
    {
        $posts = $this->postDao->findAllWithPageOrderByRecently($lastId);
        return new PostFeedDto(array_map(function ($post) {
            return PostDto::create($post);
        }, $posts), $lastId - count($posts));
    }

    public function findFirstFeed(): PostFeedDto
    {
        $posts = $this->postDao->findByFirstPageOrderByRecently();
        return new PostFeedDto(array_map(function ($post) {
            return PostDto::create($post);
        }, $posts), min(array_map(function (Post $post) {
            return $post->getId();
        }, $posts)));
    }
}
