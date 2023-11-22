<?php

namespace Tests\Unit;

use App\Exceptions\CustomException;
use App\Http\applications\AuthService;
use App\Http\applications\PostService;
use App\Http\applications\SavePostDto;
use App\Http\applications\TokenDto;
use App\Http\auths\JwtProvider;
use App\Http\auths\JwtValidator;
use App\Http\daos\PostDao;
use App\Http\daos\UserDao;
use App\Http\models\User;
use PHPUnit\Framework\MockObject\Exception;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    private AuthService $authService;
    private UserDao $userDao;

    private JwtProvider $jwtProvider;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->userDao = $this->createMock(UserDao::class);
        $this->jwtProvider = $this->createMock(JwtProvider::class);
        $this->authService = new AuthService($this->userDao, $this->jwtProvider);
    }

    /**
     * @test
     */
    public function signUp()
    {
        $this->userDao->expects($this->once())
            ->method("existsUser")
            ->willReturn(false);
        $this->userDao->expects($this->once())
            ->method("save")
            ->willReturn(1000);
        $id = $this->authService->signUp("kims", "2313#@$!@#@#@!#QSda");
        $this->assertEquals(1000, $id);
    }

    /**
     * @test
     */
    public function signUp_user_not_found()
    {
        $this->userDao->expects($this->once())
            ->method("existsUser")
            ->willReturn(true);
        $this->assertThrows(function () {
            return $this->authService->signUp("kims", "password");
        }, CustomException::class, "duplicated user name!");
    }

//    /**
//     * @test
//     */
//    public function getToken()
//    {
//        $this->userDao->expects($this->once())
//            ->method("findByUserName")
//            ->willReturn(new User(1000, "kims", "M@K#MKL!#ML@!KMLKDAS"));
//
//        $this->jwtProvider->expects($this->once())
//            ->method("generate")
//            ->willReturn(new TokenDto("fake.token.dess", "Bearer", now()));
//        $tokenDto = $this->authService->getToken("kims", "M@K#MKL!#ML@!KMLKDAS");
//        $this->assertEquals($tokenDto->getToken(), "fake.token.dess");
//        $this->assertEquals($tokenDto->getType(), "Bearer");
//        $this->assertEquals($tokenDto->getExpiredTime(), 60 * 60 * 3);
//    }

}
