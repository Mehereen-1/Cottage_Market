<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Seller;

class Product extends Model
{
    //
    protected $fillable = ['user_id','title','description','price','category','image','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function seller() {
    return $this->belongsTo(Seller::class, 'user_id'); // assuming user_id in products points to seller
}

}
