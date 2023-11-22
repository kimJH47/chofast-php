<?php

namespace App\Http\Controllers;

use App\Http\applications\PostService;
use App\Http\applications\SavePostDto;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

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

    public function findOne(string $id): JsonResponse
    {
        $postDto = $this->postService->findOne($id);
        return response()->json($postDto);
    }

    public function save(Request $request): JsonResponse
    {
        $id = $this->postService->save(savePostDto: SavePostDto::create($request::getContent()));
        return response()->json(['id' => $id], 201)
            ->header('Location', $request::host() . '/api/post/' . $id);
    }

    public function findByRecently(int $lastId): JsonResponse
    {
        return response()->json($this->postService->findByRecently($lastId));
    }

    public function findFirstFeed(): JsonResponse
    {
        return response()->json($this->postService->findFirstFeed());
    }

    public function findUserLog(Request $request): JsonResponse
    {
        $username = $request::query('userName');
        $lastId = $request::query('lastId');
        return response()->json($this->postService->findByUserName($username, $lastId));
    }

    public function findUserLogFirstPage(Request $request) : JsonResponse
    {
        $userName = $request::query('userName');
        $byUserNameFirstPage = $this->postService->findByUserNameFirstPage($userName);
        return response()->json($byUserNameFirstPage);
    }
}
