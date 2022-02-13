<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Images;
use App\Models\Products;
use App\Models\subCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SubCatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        request()->validate([
            'direction' => Rule::in(['asc', 'desc']),
            'field'     => Rule::in(['cat_name', 'categories_id', 'created_at']),
        ]);

        $query = subCat::query();
        if (request('search')) {
            $query->where('cat_name', 'LIKE', '%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }
        $categories = $query->has('categories')->with('image')->orderByRaw('created_at desc')->paginate(20)->withQueryString();
        if(count($categories) > 0){
            for ($i=0;$i< count($categories);$i++){
                $cat_name[$i] = Categories::where('id', $categories[$i]->categories_id)->first('cat_name');
            }
        }else{
            $cat_name = null;
        }
        return Inertia::render('subCat/Index', [
            'categories' => $categories,
            'cat_name' => $cat_name,
            'filters' => request()->all(['search', 'field', 'direction']),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('subCat/Create',[
            'categories' => Categories::all(),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subcat = subCat::create([
            'cat_name' => $request->cat_name,
            'categories_id' => $request->cat_id,
        ]);
        $img_url = $request->file('img_url')->store('subCat', 'public');
        $subcat->image()->save(
            Images::make(['img_url' => $img_url])
        );
        return Redirect::route('subcat.index')->with('success', 'Added Successfuly');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subCat  $subCat
     * @return \Illuminate\Http\Response
     */
    public function show($subCat)
    {
        $products = Products::where('sub_cats_id', $subCat)->orderBy('created_at', 'desc')->paginate(30);

        $subcat = subCat::findOrFail($subCat);
        $categories = Categories::where('id', $subcat->categories_id)->get();
        return Inertia::render('subCat/Products', [
            'products' => $products,
            'categories' => $categories,
            'subcat' => $subcat->cat_name,
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
            'fromDash' => false,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subCat  $subCat
     * @return \Illuminate\Http\Response
     */
    public function edit($subCat)
    {
        $subCat = subCat::findOrFail($subCat);
        $cat_name = Categories::all();
        $subCat->image;
        return Inertia::render('subCat/Edit', [
            'categories' => $subCat,
            'cat_name' => $cat_name,
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subCat  $subCat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subCat)
    {
        $categories = subCat::findOrFail($subCat);
        if(($request->cat_name !== $categories->cat_name) || ($request->file('img_url') !== null) || ($request->categories_id !== $categories->categories_id)){
            if($request->cat_name !== $categories->cat_name){
                $request->validate([
                    'cat_name' => 'unique:sub_cats|required'
                ]);
            }
            $categories->update([
                'cat_name' => $request->cat_name,
                'categories_id' => $request->categories_id
            ]);
            if($request->file('img_url') !== null){
                $request->validate([
                    'img_url' => 'mimes:jpeg,jpg,gif,png|max:2000',
                ]);
                if(Storage::disk('public')->exists($categories->image->img_url)){
                    Storage::disk('public')->delete($categories->image->img_url);
                }
                $categories->image->img_url = $request->file('img_url')->store('subCat', 'public');
                $categories->image()->update(
                    ['img_url' => $categories->image->img_url]
                );
            }
            return Redirect::route('subcat.index')->with('success', 'Updated Successfuly');
        }else{
            return Redirect::route('subcat.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subCat  $subCat
     * @return \Illuminate\Http\Response
     */
    public function destroy($subCat)
    {
        $categories = subCat::findOrFail($subCat);
        if(file_exists(public_path('storage/' . $categories->image->img_url))){
            unlink(public_path('storage/' . $categories->image->img_url));
        }
        $categories->image()->delete();
        $categories->delete();

        return Redirect::route('subcat.index')->with('success', 'Deleted Successfuly');
    }
}
