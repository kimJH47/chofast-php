<?php

namespace Tests\Unit;

use App\Exceptions\CustomException;
use App\Http\applications\PostService;
use App\Http\applications\SavePostDto;
use App\Http\daos\PostDao;
use App\Http\daos\UserDao;
use App\Http\models\Post;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class PostServiceTest extends TestCase
{

    private PostService $postService;
    private PostDao $postDao;
    private UserDao $userDao;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->postDao = $this->createMock(PostDao::class);
        $this->userDao = $this->createMock(UserDao::class);
        $this->postService = new PostService($this->postDao, $this->userDao);
    }

    /**
     * @test
     */
    public function save(): void
    {
        $this->userDao->expects($this->once())
            ->method("existsUser")
            ->willReturn(true);
        $this->postDao->expects($this->once())
            ->method("save")
            ->willReturn(10);

        $savePostDto = new SavePostDto("content", "kims");
        $id = $this->postService->save($savePostDto);
        $this->assertEquals(10, $id);
    }

    /**
     * @test
     */
    public function post_user_not_found()
    {
        $this->userDao->expects($this->once())
            ->method("existsUser")
            ->willReturn(false);

        $this->assertThrows(function () {
            $savePostDto = new SavePostDto("content", "kims");
            return $this->postService->save($savePostDto);
        }, CustomException::class, "user not found");
    }

    /**
     * @test
     */
    public function findOne()
    {
        $this->postDao->expects($this->once())
            ->method("findOneById")
            ->willReturn(new Post(100, "hello", now(), "kims"));

        $postDto = $this->postService->findOne(100);
        $this->assertEquals($postDto->getId(), 100);
        $this->assertEquals($postDto->getContent(), "hello");
        $this->assertEquals($postDto->getUserName(), "kims");
    }

    /**
     * @test
     */
    public function findOne_post_not_found()
    {
        $this->postDao->expects($this->once())
            ->method("findOneById")
            ->willThrowException(new CustomException("post not found"));

        $this->assertThrows(function () {
            $savePostDto = new SavePostDto("content", "kims");
            return $this->postService->findOne(100);
        }, CustomException::class, "post not found");
    }

    /**
     * @test
     */
    public function findByFirstPage()
    {
        $posts = [
            $this->createPost(101,"cotent12","kims"),
            $this->createPost(102,"cotent13","tray"),
            $this->createPost(103,"cotent14","kims"),
            $this->createPost(104,"cotent15","tray"),
            $this->createPost(105,"cotent16","kims"),
        ];

        $this->postDao->expects($this->once())
            ->method("findByFirstPageOrderByRecently")
            ->willReturn($posts);

        $postFeedDto = $this->postService->findFirstFeed();
        $this->assertEquals(count($postFeedDto->getPosts()),5);
    }
    /**
     * @test
     */
    public function findByRecently()
    {
        $posts = [
            $this->createPost(101,"cotent12","kims"),
            $this->createPost(102,"cotent13","tray"),
            $this->createPost(103,"cotent14","kims"),
            $this->createPost(104,"cotent15","tray"),
            $this->createPost(105,"cotent16","kims"),
            $this->createPost(106,"cotent16","kims"),
            $this->createPost(107,"cotent16","kims"),
            $this->createPost(108,"cotent16","kims"),
        ];

        $this->postDao->expects($this->once())
            ->method("findAllWithPageOrderByRecently")
            ->willReturn($posts);

        $postFeedDto = $this->postService->findByRecently(100);
        $this->assertEquals(count($postFeedDto->getPosts()),8);
    }

    /**
     * @test
     */
    public function findByUserNameFirstPage()
    {
        $posts = [
            $this->createPost(101,"sadsad","kims"),
            $this->createPost(102,"sdsamlk12m32l1","kims"),
            $this->createPost(103,"하루종일","kims"),
        ];

        $this->postDao->expects($this->once())
            ->method("findByUserNameFirstPage")
            ->willReturn($posts);

        $postFeedDto = $this->postService->findByUserNameFirstPage("kims");
        $this->assertEquals(count($postFeedDto->getPosts()),3);
    }

    /**
     * @test
     */
    public function findByUserName()
    {
        $posts = [
            $this->createPost(101,"sadsad","kims"),
            $this->createPost(102,"sdsamlk12m32l1","kims"),
        ];

        $this->postDao->expects($this->once())
            ->method("findByUserNameWithPageNation")
            ->willReturn($posts);

        $postFeedDto = $this->postService->findByUserName("kims",100);
        $this->assertEquals(count($postFeedDto->getPosts()),2);
    }


    private function createPost(int $id, string $content, string $name) :Post
    {
        return new Post($id, $content, now(), $name);
    }
}
