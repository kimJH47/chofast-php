<?php

namespace App\Http\daos;

use App\Exceptions\CustomException;
use App\Http\models\User;
use Illuminate\Support\Facades\DB;

class UserDao
{

    private const TABLE_NAME = "user_info";

    public function existsUser(string $userName): bool
    {
        return DB::table(self::TABLE_NAME)
                ->select("nick_name")
                ->where("nick_name", $userName)
                ->first() != null;
    }

    /**
     * @throws CustomException
     */
    public function findByUserName(string $user): User
    {
        $model = DB::table(self::TABLE_NAME)
            ->where("nick_name", $user)
            ->first();
        $this->validateNull($model);
        return User::createWithModel($model);
    }

    /**
     * @throws CustomException
     */
    private function validateNull($model): void
    {
        if ($model === null) {
            throw new CustomException("not found post");
        }
    }

    public function save(string $userName, string $password): int
    {
        return DB::table(self::TABLE_NAME)
            ->insertGetId(["nick_name" => $userName, "password" => $password]);
    }
}
