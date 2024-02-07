<?php

namespace App\Services;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;

class PostService
{
    public function createPost(PostStoreRequest $request)
    {
        $post = Post::create($request->validated());

        $post->categories()->sync($request->get('categories'));
        $post->categories()->sync($request->get('tags'));

        return $post;
    }

    public function updatePost($id, $data): Post
    {
        $post = Post::findorFail($id);
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->save();

        return $post;
    }

    public function deletePost($id)
    {
        if (empty(Post::destroy($id))) {
            return response()->json([
                'message' => 'Delete operation unsuccessful!'
            ]);
        }
        return response()->json([
            'message' => 'Delete operation successful!',
        ]);
    }
}
