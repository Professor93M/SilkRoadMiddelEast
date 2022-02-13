<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subCat extends Model
{
    use HasFactory;
    protected $fillable =[
        'cat_name',
        'categories_id',
    ];

    public function categories(){
        return $this->belongsTo(Categories::class);
    }

    public function image(){
        return $this->morphOne(Images::class, 'img');
    }
}
