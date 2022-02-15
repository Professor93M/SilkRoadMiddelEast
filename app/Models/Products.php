<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'pd_name',
        'pd_price',
        'pd_state',
        'pd_stack',
        'pd_description',
        'company',
        'review',
        'cover',
        'categories_id',
        'sub_cats_id',
    ];

    public function images(){
        return $this->morphMany(Images::class, 'img');
    }

    public function categories(){
        return $this->belongsTo(subCat::class);
    }
}
