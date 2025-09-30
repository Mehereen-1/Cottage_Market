<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerApplicationController extends Controller
{
    //
    public function store(Request $request)
    {
        // simple validation
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // insert into seller_applications
        DB::table('seller_applications')->insert([
            //'user_id' => 3, // for testing, assume user ID 1
            'user_id' => $request->id,
            'message' => $request->message,
            'commission_rate' => $request->commission_rate,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/apply-seller')->with('success', 'Application submitted!');
    }
}
