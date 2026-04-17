<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\DAO\CategoryDAO;
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(private CategoryDAO $categoryDAO)
    {
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403, 'Only administrators can manage categories.');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json($this->categoryDAO->getAll());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->ensureAdmin();
        $category = $this->categoryDAO->create($request->validated());
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->ensureAdmin();
        $category = $this->categoryDAO->update($category, $request->validated());
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->ensureAdmin();
        $this->categoryDAO->delete($category);
        return response()->json(null, 204);
    }
}
