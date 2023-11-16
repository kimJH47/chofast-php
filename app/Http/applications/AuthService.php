<?php

namespace App\Http\applications;

use App\Exceptions\CustomException;
use App\Http\auths\JwtProvider;
use App\Http\daos\UserDao;

class AuthService
{
    private UserDao $userDao;
    private JwtProvider $jwtProvider;

    /**
     * @param UserDao $userDao
     * @param JwtProvider $jwtProvider
     */
    public function __construct(UserDao $userDao, JwtProvider $jwtProvider)
    {
        $this->userDao = $userDao;
        $this->jwtProvider = $jwtProvider;
    }


    /**
     * @throws CustomException
     */
    public function getToken(string $userName, string $password): string
    {
        $user = $this->userDao->findByUserName($userName);
        if (!$user->isMatchedPassword(password_hash($password, PASSWORD_BCRYPT))) {
            throw new CustomException("password not matched");
        }
        return $this->jwtProvider->generate($userName);
    }
}
