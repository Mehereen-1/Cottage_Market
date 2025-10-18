<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Delivery;
use App\Notifications\ActivityNotification;

class OrderController extends Controller
{
    public function checkout()
    {
        $userId = auth()->id();
        
        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $order = Order::create([
            'user_id' => $userId,
            'status' => 'pending',
            'total_amount' => $total,
            'payment_status' => 'unpaid',
            'payment_method' => null,
            'transaction_id' => null,
            'shipping_address' => 'Default Address',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'subtotal' => $item->product->price * $item->quantity,
            ]);
        }

        // Clear the cart
        CartItem::where('user_id', $userId)->delete();

        return redirect()->route('payment.show', $order->id);

    }

    public function allOrders()
    {
        $orders = Order::with(['user', 'delivery'])->latest()->get();
        $delivery = Delivery::first(); // only one delivery authority

        return view('orders.all', compact('orders', 'delivery'));
    }

    public function myOrders()
    {
        $userId = auth()->id();
        $orders = Order::where('user_id', $userId)->orderBy('created_at', 'desc')->get();
        return view('orders.myOrders', compact('orders'));
    }

    public function assignToDelivery($id)
    {
        $order = Order::findOrFail($id);

        // Find the delivery user
        $deliveryUser = User::where('role', 'delivery')->first();

        if (!$deliveryUser) {
            return redirect()->back()->with('error', 'No delivery account found!');
        }

        // Create a new record in deliveries table
        Delivery::create([
            'order_id' => $order->id,
            'status' => 'Assigned to delivery',
        ]);
        $order->save();
        $message = "A new order #{$order->id} has been assigned to you for delivery.";
        $type = 'delivery_assignment';
        $deliveryUser->notify(new ActivityNotification($message, $type));
        return redirect()->route('orders.all')->with('success', 'Order assigned to delivery authority!');
    }

    public function show(Order $order)
    {
        // Eager load related models
        $order->load(['user', 'items.product', 'items.product.seller', 'delivery']);

        // Authorization: either admin, delivery authority, or owner
        $user = auth()->user();
        if ($user->role !== 'admin' && $user->role !== 'delivery' && $order->user_id !== $user->id) {
            abort(403, 'Unauthorized access to this order');
        }

        return view('orders.show', compact('order'));
    }


}
