<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $fillable = [
        'or_name',
        'or_price',
        'count',
        'cart_id',
        'products_id',
    ];

    // protected $primaryKey = 'order_id';

    public function carts(){
        return $this->belongsTo(Cart::class);
    }
}
