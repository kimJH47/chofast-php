<?php

namespace App\Http\daos;


use App\Exceptions\CustomException;
use App\Http\models\Post;
use Illuminate\Support\Facades\DB;

class PostDao
{
    private const TABLE_NAME = "post";

    /**
     * @throws \Exception
     */
    public function findOneById(int $id): Post
    {
        $model = DB::table(self::TABLE_NAME)
            ->where("id", $id)
            ->first();
        $this->validateNull($model);
        return Post::createWithModel($model);
    }

    /**
     * @throws \Exception
     */
    private function validateNull($model): void
    {
        if ($model === null) {
            throw new CustomException("null인데요");
        }
    }
}
