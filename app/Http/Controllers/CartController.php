<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // For demo, using a test user with ID=3
        $user = User::find(3);
        if (!$user) {
            return "User not found!";
        }

        // Fetch cart items with related product
        $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Pass data to the view
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        // Logic to add product to cart
        // $user = auth()->user(); // assuming user is logged in
        $user = User::find(3); // for demo, using a test user with ID=3
        if (!$user) {
            return "User not found!";
        }
        $cartItem = CartItem::where('user_id', $user->id)
                             ->where('product_id', $productId)
                             ->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove(Request $request, $cartItemId)
    {
        // Logic to remove product from cart
        // $user = auth()->user(); // assuming user is logged in
        $user = User::find(3); // for demo, using a test user with ID=3
        if (!$user) {
            return "User not found!";
        }
        $cartItem = CartItem::where('id', $cartItemId)
                             ->where('user_id', $user->id)
                             ->first();
        if ($cartItem) {
            $cartItem->delete();
            return redirect()->back()->with('success', 'Product removed from cart!');
        } else {
            return redirect()->back()->with('error', 'Cart item not found!');
        }
    }

    // public function view()
    // {
    //     // $user = auth()->user();
    //     $user = User::find(3); // for demo, using a test user with ID=3
    //     if (!$user) {
    //         return "User not found!";
    //     }
    //     $cartItems = CartItem::where('user_id', $user->id)->with('product')->get();
    //     return view('cart.index', compact('cartItems'));
    // }   
}
