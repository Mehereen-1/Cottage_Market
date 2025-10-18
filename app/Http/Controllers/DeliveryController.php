<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Delivery;
use App\Models\Order;
use App\Notifications\ActivityNotification;
use App\Models\User;

class DeliveryController extends Controller
{
    // Show all deliveries
    public function index()
    {
        $deliveries = Delivery::with('order.user')->orderBy('created_at', 'desc')->get();
        return view('delivery.index', compact('deliveries'));
    }

    // Update delivery status
    public function updateStatus(Request $request, Delivery $delivery)
    {
        $request->validate([
            'status' => 'required|in:pending,picked,shipped,delivered',
        ]);

        $delivery->update(['status' => $request->status]);

        // Optional: update order status to match
        //$delivery->order->update(['status' => $request->status]);
        $messageAdmin = "Delivery for Order #{$delivery->order->id} updated to {$request->status}.";
        $typeAdmin = 'delivery_status_update';
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ActivityNotification($messageAdmin, $typeAdmin));
        } 

        $messageUser = "Your order #{$delivery->order->id} delivery status is now {$request->status}.";
        $typeUser = 'delivery_status_update';
        $delivery->order->user->notify(new \App\Notifications\ActivityNotification($messageUser, $typeUser));

        return back()->with('success', 'Delivery status updated!');
    }
}
