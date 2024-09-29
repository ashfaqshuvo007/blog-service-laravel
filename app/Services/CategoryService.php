<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryService
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function update($id, array $data): Category
    {
        $category = Category::findOrFail($id);
        $category->title = $data['title'];
        $category->description = $data['description'];
        $category->save();

        return $category;
    }

    public function delete($id): JsonResponse
    {
        if (empty(Category::destroy($id))) {
            return response()->json([
                'message' => 'Delete operation unsuccessful!'
            ]);
        }
        return response()->json([
            'message' => 'Delete operation successful!',
        ]);
    }
}
