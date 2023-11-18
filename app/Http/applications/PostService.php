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
        return new PostFeedDto($this->createPosts($posts), $lastId - count($posts));
    }

    public function findFirstFeed(): PostFeedDto
    {
        $posts = $this->postDao->findByFirstPageOrderByRecently();
        return new PostFeedDto($this->createPosts($posts), $this->calculateLastId($posts));
    }

    public function findByUserName(string $userName, int $lastId): PostFeedDto
    {
        $posts = $this->postDao->findByUserNameWithPageNation($userName, $lastId);
        return new PostFeedDto($this->createPosts($posts), $lastId - count($posts));
    }

    public function findByUserNameFirstPage(string $userName): PostFeedDto
    {
        $posts = $this->postDao->findByUserNameFirstPage($userName);
        return new PostFeedDto($this->createPosts($posts), $this->calculateLastId($posts));
    }

    /**
     * @param array $posts
     * @return PostDto[]|array
     */
    private function createPosts(array $posts): array
    {
        return array_map(function ($post) {
            return PostDto::create($post);
        }, $posts);
    }

    /**
     * @param array $posts
     * @return int
     */
    private function calculateLastId(array $posts): int
    {
        return min(array_map(function (Post $post) {
            return $post->getId();
        }, $posts));
    }
}
