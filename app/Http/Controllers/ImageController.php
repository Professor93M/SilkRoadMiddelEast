<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\Categories;
use App\Models\Products;
use App\Models\subCat;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all($folder ,$image)
    {
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function cats($id, $folder, $image){
        Categories::findOrFail($id);
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function cat($folder, $image){
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function subcategories($folder, $image){
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function subcats($folder, $image){
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function subcat($folder, $image){
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function subcatid($id, $folder, $image){
        subCat::findOrFail($id);
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function prod($id, $folder, $image){
        Products::findOrFail($id);
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function products($folder, $image){
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
    public function car($id, $folder, $image){
        Carousel::findOrFail($id);
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }

    public function dash($folder, $image){
        $path = ($folder .'/'.$image);
        if(!Storage::disk('public')->exists($path)){
            abort(404);
        }else{
            $file = Storage::disk('public')->get($path);
            return $file;
        }
    }
}
