<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        CategoryRequest $request,
        CategoryService $categoryService
    ): CategoryResource {
        return CategoryResource::make(
            Category::find($categoryService->create($request->validated())->id)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): CategoryResource
    {
        return CategoryResource::make(Category::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CategoryRequest $request,
        string $id,
        CategoryService $categoryService
    ): CategoryResource {
        return CategoryResource::make(
            $categoryService->update($id, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, CategoryService $categoryService): JsonResponse
    {
        return $categoryService->delete($id);
    }
}
