<?php

namespace App\Http\daos;


use App\Exceptions\CustomException;
use App\Http\models\Post;
use Exception;
use Illuminate\Support\Facades\DB;

class PostDao
{
    private const TABLE_NAME = "post";

    /**
     * @throws Exception
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
     * @throws Exception
     */
    private function validateNull($model): void
    {
        if ($model === null) {
            throw new CustomException("not found post");
        }
    }

    public function save(string $content, string $userName): int
    {
        return DB::table(self::TABLE_NAME)
            ->insertGetId(
                [
                    'content' => $content,
                    'created_at' => now(),
                    'user_name' => $userName
                ]
            );
    }

    public function findAllWithPageOrderByRecently(int $lastId): array
    {
        $posts = DB::table(self::TABLE_NAME)
            ->select('id', 'content', 'user_name', 'created_at')
            ->where("id", '<', $lastId)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
        if ($posts == null) {
            return [];
        }
        return array_map(array($this, 'mapToPost'), $posts);
    }

    public function findByFirstPageOrderByRecently(): array
    {
        $posts = DB::table(self::TABLE_NAME)
            ->select('id', 'content', 'user_name', 'created_at')
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
        if ($posts == null) {
            return [];
        }
        return array_map(array($this, 'mapToPost'), $posts);
    }

    public function findByUserNameWithPageNation(string $userName, int $lastId): array
    {
        $posts = DB::table(self::TABLE_NAME)
            ->select('id', 'content', 'user_name', 'created_at')
            ->where("id", '<', $lastId)
            ->where('user_name', $userName)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
        if ($posts == null) {
            return [];
        }
        return array_map(array($this, 'mapToPost'), $posts);
    }

    public function findByUserNameFirstPage(string $userName) : array
    {
        $posts = DB::table(self::TABLE_NAME)
            ->select('id', 'content', 'user_name', 'created_at')
            ->where('user_name', $userName)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get()
            ->toArray();
        if ($posts == null) {
            return [];
        }
        return array_map(array($this, 'mapToPost'), $posts);
    }

    private function mapToPost($row): Post
    {
        return new Post($row->id, $row->content, $row->created_at, $row->user_name);
    }
}
