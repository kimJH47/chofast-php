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
        if (!$user->isMatchedPassword($password)) {
            throw new CustomException("password not matched");
        }
        return $this->jwtProvider->generate($userName);
    }

    public function signUp(string $userName, string $password): int
    {
        $this->validateUserName($userName);
        return $this->userDao->save($userName, password_hash($password, PASSWORD_BCRYPT));
    }

    /**
     * @throws CustomException
     */
    private function validateUserName(string $userName): void
    {
        if ($this->userDao->existsUser($userName)) {
            throw new CustomException("duplicated user name!");
        }
    }
}
