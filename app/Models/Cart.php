<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    // protected $table = 'carts';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'governorate',
        'mobile',
        'mobile2',
        'address',
        'location',
        'comment',
    ];
    public function orders(){
        return $this->hasMany(Orders::class);
    }
}
