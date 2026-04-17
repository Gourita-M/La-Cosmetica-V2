<?php

namespace App\DAO;

use Illuminate\Support\Facades\DB;

class StatisticsDAO
{
    /**
     * Statuses that should count toward statistics.
     *
     * @return array<int, string>
     */
    private function trackableStatuses(): array
    {
        return ['pending', 'being_prepared', 'delivered'];
    }

    /**
     * Get the total historical sales amount for valid orders.
     */
    public function getTotalSales(): float
    {
        return (float) DB::table('orders_items')
            ->join('orders', 'orders_items.orders_id', '=', 'orders.id')
            ->select(DB::raw('SUM(orders_items.quantity * orders_items.unit_price) as total_sales'))
            ->whereIn('orders.status', $this->trackableStatuses())
            ->first()
            ->total_sales ?? 0;
    }

    /**
     * Get the most popular products sold.
     */
    public function getPopularProducts(int $limit = 5)
    {
        return DB::table('orders_items')
            ->join('orders', 'orders_items.orders_id', '=', 'orders.id')
            ->join('products', 'orders_items.products_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(orders_items.quantity) as total_quantity'))
            ->whereIn('orders.status', $this->trackableStatuses())
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_quantity')
            ->limit($limit)
            ->get();
    }

    /**
     * Get distribution of sales by category.
     */
    public function getCategoryDistribution()
    {
        return DB::table('orders_items')
            ->join('orders', 'orders_items.orders_id', '=', 'orders.id')
            ->join('products', 'orders_items.products_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(orders_items.quantity) as total_sold'))
            ->whereIn('orders.status', $this->trackableStatuses())
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_sold')
            ->get();
    }
}
