<?php

namespace Tests\Unit;

use App\Exceptions\CustomException;
use App\Http\applications\PostDto;
use App\Http\applications\PostService;
use App\Http\applications\SavePostDto;
use App\Http\daos\PostDao;
use App\Http\daos\UserDao;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;
use function Symfony\Component\Translation\t;

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
            ->willThrowException(new CustomException("user not found"));

        $this->assertThrows(function () {
            $savePostDto = new SavePostDto("content", "kims");
            return $this->postService->save($savePostDto);
        }, CustomException::class, "user not found");
    }
}
