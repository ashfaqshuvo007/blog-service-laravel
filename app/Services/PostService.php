<?php

namespace App\Services;


use App\Models\Post;

class PostService
{
    public function createPost($data)
    {
        $post = Post::create($data->validated());

        $post->categories()->sync($data->get('categories'));
        $post->categories()->sync($data->get('tags'));

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

    public function deletePost($id): \Illuminate\Http\JsonResponse
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
