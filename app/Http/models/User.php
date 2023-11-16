<?php

namespace App\Http\models;

use App\Http\daos\UserDao;

class User
{
    private int $id;
    private string $nickName;
    private string $password;

    /**
     * @param int $id
     * @param string $nickName
     * @param string $password
     */
    public function __construct(int $id, string $nickName, string $password)
    {
        $this->id = $id;
        $this->nickName = $nickName;
        $this->password = $password;
    }


    public function isMatchedPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function createWithModel($model): User
    {
        return new User($model->id, $model->nick_name, $model->password);
    }
}
