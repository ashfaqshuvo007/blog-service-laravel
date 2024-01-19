<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory()->count(5)->create();

        foreach ($posts as $post) {
            $categories = Category::inRandomOrder()->limit(5)->get();
            $tags = Tag::inRandomOrder()->limit(5)->get();

            $post->categories()->sync($categories->pluck('id'));
            $post->tags()->sync($tags->pluck('id'));
        }
    }
}
