<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $fillable = ['seller_id','month','total_sales','admin_cut','net_amount','status','paid_at'];

    public function seller() { return $this->belongsTo(Seller::class); }
}

