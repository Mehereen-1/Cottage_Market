<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\CartItem;

class OrderController extends Controller
{

    public function checkout()
    {
        // $user = auth()->user();
        $user = User::find(3); // for demo, using a test user with ID=3
        if (!$user) {
            return "User not found!";
        }
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        $order = Order::create([
            'user_id' => $user->id,
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
        CartItem::where('user_id', $user->id)->delete();

        return redirect()->route('payment.show', $order->id);

    }

}
