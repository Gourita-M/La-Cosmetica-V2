<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\DAO\ProductDAO;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(private ProductDAO $productDAO)
    {
    }

    private function productPayload(Product $product): array
    {
        return [
            'slug' => $product->slug,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image,
            'images' => $product->image ? [$product->image] : [],
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
            ] : null,
        ];
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role === 'admin', 403, 'Only administrators can manage products.');
    }

    public function showProducts()
    {
        return View('Products.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productDAO->getAllWithCategory();
        return response()->json(
            $products->map(fn (Product $product) => $this->productPayload($product))->values()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $this->ensureAdmin();
        $product = $this->productDAO->create($request->validated());
        return response()->json($product->load('category'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = $this->productDAO->findBySlugWithCategory($slug);
        return response()->json($this->productPayload($product));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->ensureAdmin();
        $product = $this->productDAO->update($product, $request->validated());
        return response()->json($product->load('category'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->ensureAdmin();
        $this->productDAO->delete($product);
        return response()->json(null, 204);
    }
}
