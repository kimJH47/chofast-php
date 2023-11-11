<?php

namespace App\Http\daos;

use Illuminate\Support\Facades\DB;

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
}
