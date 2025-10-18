<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'status',
    ];

    // Relationship: each delivery belongs to one order
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id');
    }

}
