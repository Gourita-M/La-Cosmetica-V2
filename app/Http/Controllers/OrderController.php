<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\DAO\OrderDAO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $orderDAO;

    public function __construct(OrderDAO $orderDAO)
    {
        $this->orderDAO = $orderDAO;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'employee'], true)) {
            $orders = $this->orderDAO->getAllOrders();
        } else {
            $orders = $this->orderDAO->getUserOrders($user->id);
        }

        return response()->json($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        $totalAmount = 0.0;
        $orderItems = [];

        $order = DB::transaction(function () use ($validated, &$orderItems, &$totalAmount) {
            foreach ($validated['products'] as $item) {
                $product = $this->orderDAO->getProductBySlug($item['slug']);

                if (!$product) {
                    abort(404, 'Product not found: '.$item['slug']);
                }

                if ($product->stock < $item['quantity']) {
                    abort(422, 'Insufficient stock for product: '.$product->name);
                }

                $orderItems[] = [
                    'products_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ];
                $totalAmount += $product->price * $item['quantity'];
            }

            $order = $this->orderDAO->createPendingOrder(auth()->id());
            foreach ($orderItems as $item) {
                $this->orderDAO->createOrderItemAndDecrementStock($order, $item);
            }

            return $order;
        });

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order->load('items.product'),
            'total_amount' => $totalAmount
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $user = auth()->user();

        if ($order->users_id !== $user->id && !in_array($user->role, ['admin', 'employee'], true)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order->load('items.product', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:being_prepared,delivered'
        ]);

        if (!in_array(auth()->user()->role, ['admin', 'employee'], true)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($order->status === 'cancelled') {
            return response()->json(['message' => 'Cancelled orders cannot be updated.'], 422);
        }

        if ($order->status === 'delivered') {
            return response()->json(['message' => 'Delivered orders cannot be updated.'], 422);
        }

        if ($order->status === 'pending' && $request->status === 'delivered') {
            return response()->json(['message' => 'Order must be marked as being prepared before delivery.'], 422);
        }

        $this->orderDAO->updateOrderStatus($order, $request->status);

        return response()->json($order);
    }

    public function cancel(Order $order)
    {
        $user = auth()->user();

        if ($order->users_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized. Only the order owner can cancel their order.'], 403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['message' => 'Order can only be cancelled while it is pending.'], 422);
        }

        DB::transaction(function () use ($order) {
            $order->load('items.product');
            $this->orderDAO->updateOrderStatus($order, 'cancelled');
            $this->orderDAO->restockOrderItems($order);
        });

        return response()->json(['message' => 'Order successfully canceled', 'order' => $order]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
