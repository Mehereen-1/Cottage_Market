<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
    public function approveSeller($applicationId)
    {
        $app = \DB::table('seller_applications')->where('id',$applicationId)->first();
        if(!$app) abort(404);
        $user = \App\Models\User::find($app->user_id);
        $user->role = 'student';
        $user->save();

        \DB::table('seller_applications')->where('id',$applicationId)->update(['status'=>'approved']);
        return back()->with('success','Seller approved');
    }

    public function rejectSeller($applicationId)
    {
        DB::table('seller_applications')
        ->where('id', $applicationId)
        ->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Seller application rejected.');
    }

    public function approveProduct($productId)
    {
        $product = \App\Models\Product::findOrFail($productId);
        $product->status = 'approved';
        $product->save();
        return back()->with('success','Product approved');
    }
    public function rejectProduct($productId)
    {
        DB::table('products')
        ->where('id', $productId)
        ->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Product application rejected.');
    }

}
