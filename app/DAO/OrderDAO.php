<?php

namespace App\DAO;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class OrderDAO
{
    /**
     * Get all orders in the system.
     */
    public function getAllOrders(): Collection
    {
        return Order::with('items.product', 'user')->get();
    }

    /**
     * Get all orders belonging to a specific user.
     */
    public function getUserOrders(int $userId): Collection
    {
        return Order::with('items.product')
            ->where('users_id', $userId)
            ->get();
    }

    /**
     * Retrieve a product by its slug.
     */
    public function getProductBySlug(string $slug): ?Product
    {
        return Product::where('slug', $slug)->first();
    }

    /**
     * Set up a new pending order for a specific user ID.
     */
    public function createPendingOrder(int $userId): Order
    {
        return Order::create([
            'users_id' => $userId,
            'status' => 'pending',
        ]);
    }

    /**
     * Append an item to an order and correctly deduct the necessary stock from the product.
     */
    public function createOrderItemAndDecrementStock(Order $order, array $item): void
    {
        $order->items()->create($item);
        
        $product = Product::find($item['products_id']);
        if ($product) {
            $product->decrement('stock', $item['quantity']);
        }
    }

    /**
     * Update the overarching status string on the order model.
     */
    public function updateOrderStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);
    }

    /**
     * Restore product quantities from each order item.
     */
    public function restockOrderItems(Order $order): void
    {
        foreach ($order->items as $item) {
            $item->product?->increment('stock', $item->quantity);
        }
    }
}
