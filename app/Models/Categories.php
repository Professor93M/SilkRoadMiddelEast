<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable=[
        'cat_name',
    ];

    public function subCat(){
        return $this->hasMany(subCat::class);
    }
    public function image(){
        return $this->morphOne(Images::class, 'img');
    }

    // protected $primaryKey = 'cat_id';
}
