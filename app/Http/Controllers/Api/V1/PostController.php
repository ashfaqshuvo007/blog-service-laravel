<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request, PostService $postService)
    {
        return PostResource::make(
            Post::find(
                $postService->createPost($request)->id
            )
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): PostResource
    {
        return PostResource::make(Post::findOrFail($id));
    }

    /**
     * Display the specified resource by Slug.
     */
    public function singlePost(string $slug): PostResource
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PostUpdateRequest $request,
        string $id,
        PostService $postService
    ) {
        return PostResource::make(
            $postService->updatePost($id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, PostService $postService)
    {
        return $postService->deletePost($id);
    }
}
