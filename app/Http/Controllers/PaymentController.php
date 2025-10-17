<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Seller;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\Payout;
use App\Notifications\ActivityNotification;
use Illuminate\Notifications\Notifiable;
use App\Models\User;


class PaymentController extends Controller
{
    public function show(Order $order)
    {
        return view('payment.show', compact('order'));
    }

    public function pay(Request $request, Order $order)
    {
        if ($order->payment_status === 'paid') {
            return redirect()->route('payment.show', $order->id)
                             ->with('error', 'This order is already paid.');
        }

        // Record payment
        $payment = Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_amount,
            'method' => 'bkash', // demo, later integrate
            'status' => 'success',
            'transaction_id' => uniqid('TXN_'),
        ]);

        // Update order status
        $order->update([
            'payment_status' => 'paid',
            'status' => 'completed',
            'payment_method' => 'bkash',
            'transaction_id' => $payment->transaction_id,
        ]);

        // Record payouts for each seller in order_items
        $orderItems = OrderItem::where('order_id', $order->id)->with('product.seller')->get();

        foreach ($orderItems as $item) {
            $seller = $item->product->seller;
            if (!$seller) continue;

            $commissionRate = $seller->commission_rate/100 ?? 0.1; // default 10%
            $subtotal = $item->subtotal;
            $adminCut = $subtotal * $commissionRate;
            $netAmount = $subtotal - $adminCut;

            $month = now()->format('Y-m'); // group by month

            // Update or create monthly payout
            $payout = Payout::firstOrNew([
                'seller_id' => $seller->id,
                'month' => $month,
            ]);

            $payout->total_sales = ($payout->total_sales ?? 0) + $subtotal;
            $payout->admin_cut = ($payout->admin_cut ?? 0) + $adminCut;
            $payout->net_amount = ($payout->net_amount ?? 0) + $netAmount;
            $payout->status = $payout->status ?? 'pending';
            $payout->save();

            $sellerMessage = "You have a new sale! Order #{$order->id} has been paid.";
            $sellerUser = $item->product->seller->user; // get the User model
            $sellerUser->notify(new ActivityNotification($sellerMessage, 'sale'));
        }

        $order->user->notify(new ActivityNotification('Your order has been placed!'));

        $message = "Payment received for Order #{$order->id}. Total Amount: {$order->total_amount}";
        $type = 'payment_received';
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ActivityNotification($message, $type));
        }

        return redirect()->route('payment.show', $order->id)
                        ->with('success', 'Payment successful! Payouts updated.');
    }
}
