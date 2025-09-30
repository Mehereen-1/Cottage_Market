<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function registerSeller(Request $request)
    {
        //$user = auth()->user();
        
        $request->validate([
            'commission_rate'=>'required|numeric|min:0|max:100',
            'bkash_number'=>'required|string',
        ]);
        $seller = Seller::updateOrCreate(
            ['user_id'=>$user->id],
            ['commission_rate'=>$request->commission_rate,'bkash_number'=>$request->bkash_number]
        );
        return redirect()->back()->with('success','Seller profile saved.');
    }

}
