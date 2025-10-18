<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'student')
            ->withCount('products')
            ->having('products_count', '>', 0)
            ->get();
            
        return view('shops.index', compact('sellers'));
    }

    public function show(User $user)
    {
        $products = $user->products()->where('status', 'approved')->get();
        return view('shops.show', compact('user', 'products'));
    }
}
