<?php

namespace App\Http\Controllers;

use App\Http\applications\PostService;

class PostController extends Controller
{

    private PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    function findOne(string $id): string
    {
        $postDto = $this->postService->findOne($id);
        return response()->json($postDto, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
