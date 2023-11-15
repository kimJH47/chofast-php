<?php

namespace App\Http\daos;

use App\Http\models\User;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\select;

class UserDao
{

    private const TABLE_NAME = "user_info";
    public function existsUser(string $userName) : bool
    {
        return DB::table(self::TABLE_NAME)
            ->select("nick_name")
            ->where("nick_name", $userName)
            ->first() != null;
    }

    public function findByUserName(string $user) : User
    {
        return User::createWithModel(DB::table(self::TABLE_NAME)
            ->select("password")
            ->where("nick_name", $user)
            ->first());
    }
}
