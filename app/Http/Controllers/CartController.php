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
        $userId = auth()->id();

        // Fetch cart items with related product
        $cartItems = CartItem::where('user_id', $userId)->with('product')->get();

        // Calculate total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Pass data to the view
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $productId)
    {
        $userId = auth()->id();
        
        $cartItem = CartItem::where('user_id', $userId)
                             ->where('product_id', $productId)
                             ->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $userId = auth()->id();
        
        $cartItem = CartItem::where('id', $cartItemId)
                             ->where('user_id', $userId)
                             ->first();
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return redirect()->back()->with('success', 'Cart updated!');
        } else {
            return redirect()->back()->with('error', 'Cart item not found!');
        }
    }

    public function remove(Request $request, $cartItemId)
    {
        $userId = auth()->id();
        
        $cartItem = CartItem::where('id', $cartItemId)
                             ->where('user_id', $userId)
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
