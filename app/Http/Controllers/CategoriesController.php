<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriesRequest;
use App\Http\Resources\CategoriesResources;
use App\Models\Categories;
use App\Models\Images;
use App\Models\logs;
use App\Models\subCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

function LogsCat($req, $text){
    logs::create([
        'log' => $text . ' ('. $req .')',
        'username' => Auth::user()->name,
        'isUser' => 2,
    ]);
}

class CategoriesController extends Controller
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
            'field'     => Rule::in(['cat_name', 'created_at']),
        ]);

        $query = Categories::query();

        if (request('search')) {
            $query->where('cat_name', 'LIKE', '%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }
        return Inertia::render('Categories/Index', [
            'categories' => $query->with('image')->orderBy('created_at','desc')->paginate(20)->withQueryString(),
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
        return Inertia::render('Categories/Create',[
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
    public function store(CategoriesRequest $request)
    {
        $categories = Categories::create([
            'cat_name' => $request->cat_name,
        ]);
        $img_url = $request->file('img_url')->store('Categories', 'public');
        $categories->image()->save(
            Images::make(['img_url' => $img_url])
        );
        LogsCat($request->cat_name, 'انشاء قسم رئيسي');

        return Redirect::route('categories.index')->with('success', 'تم انشاء القسم بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = subCat::where('categories_id', $id)->with('image')->paginate(30);
        $cat_name = Categories::select('cat_name')->where('id', $id)->first();
        return Inertia::render('Categories/SubCats', [
            'categories' => $categories,
            'cat_name' => $cat_name->cat_name,
            'filters' => request()->all(['search', 'field', 'direction']),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($categories)
    {
        $categories = new CategoriesResources(Categories::findOrFail($categories));
        $categories->image;
        return Inertia::render('Categories/Edit', [
            'categories' => $categories,
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $categories)
    {
        $categories = Categories::findOrFail($categories);
        if(($request->cat_name !== $categories->cat_name) || ($request->file('img_url') !== null)){
            if($request->cat_name !== $categories->cat_name){
                $request->validate([
                    'cat_name' => 'unique:categories|required|min:1'
                    ],[
                    'cat_name.required'        => 'يجب ادخال اسم القسم',
                    'cat_name.unique'          => 'اسم القسم موجود فعلا',
                ]);
                $categories->update(['cat_name' => $request->cat_name]);
            }
            if($request->file('img_url') !== null){
                $request->validate([
                    'img_url' => 'mimes:jpeg,jpg,gif,png|max:1000',
                    ],[
                    'img_url.mimes'       => 'امتداد الصورة المطلوب : jpeg,jpg,gif,png',
                    'img_url.max'       => 'يجب ان لا يتجاوز حجم الصورة 1MB',
                ]);
                if(Storage::disk('public')->exists($categories->image->img_url)){
                    Storage::disk('public')->delete($categories->image->img_url);
                }
                $categories->image->img_url = $request->file('img_url')->store('Categories', 'public');
                $categories->image()->update(
                    ['img_url' => $categories->image->img_url]
                );
            }
            LogsCat($request->cat_name, 'تحديث قسم رئيسي');
            return Redirect::route('categories.index')->with('success', 'تم تعديل القسم بنجاح');
        }else{
            return Redirect::route('categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($categories)
    {
        $categories = Categories::findOrFail($categories);
        if(file_exists(public_path('storage/' . $categories->image->img_url))){
            unlink(public_path('storage/' . $categories->image->img_url));
        }
        $categories->image()->delete();
        $categories->delete();

        LogsCat($categories->cat_name, 'حذف قسم رئيسي');
        return Redirect::route('categories.index')->with('success', 'تم حذف القسم بنجاح');
    }
}
