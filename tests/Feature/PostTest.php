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

    /**
     * Test Get Single Post endpoint
     */
    public function testGetPost(): void
    {
        $this->withoutMiddleware();

        //Arrange
        $post = Post::factory()->create();

        //Act
        $response = $this->withoutExceptionHandling()->get(
            "/api/v1/posts/$post->id"
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

    /**
     * Test Create Posts endpoint
     */
    public function testCreatePost(): void
    {
        $this->withoutMiddleware();

        //Arrange
        $user = User::factory()->create()->first();
        $category = Category::factory()->create()->first();
        $tags = Tag::factory()->count(2)->create();

        // Act
        $response = $this->withoutExceptionHandling()->post(
            '/api/v1/posts',
            [
                'title'      => 'Test title',
                'content'    => 'Test content',
                'author_id'  => $user->id,
                'categories' => [$category->id],
                'tags'       => [$tags[0]->id, $tags[1]->id]
            ]
        );

        // Assert
        $response->assertStatus(200)
            ->assertJson(
                fn(AssertableJson $json) => $json->whereType('data', 'array')
            );
    }

    /**
     * Test Delete Post endpoint
     */
    public function testDeletePost(): void
    {
        $this->withoutMiddleware();

        //Arrange
        $post = Post::factory()->create();
        //Act
        $response = $this->withoutExceptionHandling()->delete(
            "/api/v1/posts/$post->id"
        );
        //Assert
        $response->assertStatus(200);
    }

    /**
     * Test Delete Post endpoint
     */
    public function testGetSinglePostBySlug(): void
    {
        $this->withoutMiddleware();

        //Arrange
        $post = Post::factory()->create();
        //Act
        $response = $this->withoutExceptionHandling()->get(
            "/api/v1/post/$post->slug"
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

    /**
     * Test Unauthorized GET posts endpoint
     */
    public function testUnauthorizedGetPosts(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get("/api/v1/posts");
    }

    /**
     * Test Unauthorized GET single post endpoint
     */
    public function testUnauthorizedGetSinglePost(): void
    {
        //Arrange
        $post = Post::factory()->create();
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get("/api/v1/posts/$post->id");
    }

    /**
     * Test Unauthorized CREATE post endpoint
     */
    public function testUnauthorizedCreatePost(): void
    {
        //Arrange
        $user = User::factory()->create()->first();
        $category = Category::factory()->create()->first();
        $tags = Tag::factory()->count(2)->create();

        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        // Act
        $this->post(
            '/api/v1/posts',
            [
                'title'      => 'Test title',
                'content'    => 'Test content',
                'author_id'  => $user->id,
                'categories' => [$category->id],
                'tags'       => [$tags[0]->id, $tags[1]->id]
            ]
        );
    }

    /**
     * Test Unauthorized DELETE post endpoint
     */
    public function testUnauthorizedDeletePost(): void
    {
        //Arrange
        $post = Post::factory()->create();
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->delete("/api/v1/posts/$post->id");
    }

    /**
     * Test Unauthorized GET single post by slug endpoint
     */
    public function testUnauthorizedGetSinglePostBySlug(): void
    {
        //Arrange
        $post = Post::factory()->create();
        $this->withoutExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get("/api/v1/posts/$post->slug");
    }
}
