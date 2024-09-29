<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test Get Posts endpoint
     */
    public function testGetPosts(): void
    {
        $this->withoutMiddleware();
        //Arrange
        $posts = Post::factory()->count(3)->create();
        //Act
        $response = $this->withoutExceptionHandling()->get('/api/v1/posts');

        //Assert
        $response->assertStatus(200)
            ->assertJson(
                fn(AssertableJson $json) => $json->has('data', $posts->count())
            )
            ->assertJson(
                fn(AssertableJson $json) => $json->whereType('data', 'array')
            );
    }

    public function testGetPost(): void
    {
        $this->withoutMiddleware();

        //Arrange
        $post = Post::factory()->create();

        //Act
        $response = $this->withoutExceptionHandling()->get(
            "/api/v1/posts/{$post->id}"
        );

        //Assert
        $response->assertStatus(200)
            ->assertJson(
                fn(AssertableJson $json) => $json->whereType('data', 'array')
            )
            ->assertJson([
                'data' => [
                    'id'      => $post->id,
                    'title'   => $post->title,
                    'content' => $post->content,
                    'slug'    => $post->slug,
                ]
            ]);
    }

    public function testCreatePost(): void
    {
        $this->withoutMiddleware();

        //Arrange
        $user = User::factory()->create()->first();
        $category = Category::factory()->create()->first();
        $tags = Tag::factory()->count(2)->create();

        // Act
        $response = $this->withoutExceptionHandling()->post('/api/v1/posts',
            [
                'title' => 'Test title',
                'content' => 'Test content',
                'author_id' => $user->id,
                'categories' => [$category->id],
                'tags' => [$tags[0]->id, $tags[1]->id]
            ]
        );

        // Assert
        $response->assertStatus(200)
        ->assertJson(fn(AssertableJson $json) => $json->whereType('data', 'array'));
    }

    public function testDeletePost(): void
    {
        $this->withoutMiddleware();
        $post = Post::factory()->create();
        $response = $this->withoutExceptionHandling()->delete("/api/v1/posts/{$post->id}");
        $response->assertStatus(200);

    }
}
