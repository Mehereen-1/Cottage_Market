<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerApplicationController extends Controller
{
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Check if user is already a student (seller)
        if ($user->role === 'student') {
            return redirect('/apply-seller')->with('error', 'You are already approved as a seller!');
        }
        
        // Check if user already has a pending application
        $existingApplication = DB::table('seller_applications')
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
            
        if ($existingApplication) {
            return redirect('/apply-seller')->with('error', 'You already have a pending application. Please wait for admin review.');
        }

        // simple validation
        $request->validate([
            'message' => 'required|string|max:500',
            'commission_rate' => 'required|numeric|min:5|max:20',
        ]);

        // insert into seller_applications
        DB::table('seller_applications')->insert([
            'user_id' => $user->id,
            'message' => $request->message,
            'commission_rate' => $request->commission_rate,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/apply-seller')->with('success', 'Application submitted successfully! We will review your application and get back to you soon.');
    }
}
