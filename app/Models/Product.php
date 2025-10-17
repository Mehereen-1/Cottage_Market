<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Seller;
use App\Models\Category;

class Product extends Model
{
    //
    protected $fillable = ['user_id','title','description','price','category','image','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function seller() {
        return $this->hasOne(Seller::class, 'user_id', 'user_id'); 
        // sellers.user_id == products.user_id
    }
    public function categoryObj()
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

}
