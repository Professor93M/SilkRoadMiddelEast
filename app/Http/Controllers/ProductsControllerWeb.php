<?php

namespace App\Http\Controllers;
use App\Http\Resources\ProductsResources;
use App\Http\Requests\ProductsRequest;
use App\Models\Categories;
use App\Models\Images;
use App\Models\logs;
use App\Models\Products;
use App\Models\subCat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

function LogsP($req, $text){
    logs::create([
        'log' => $text . ' ('. $req .')',
        'username' => Auth::user()->name,
        'isUser' => 2,
    ]);
}

class ProductsControllerWeb extends Controller
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
            'field'     => Rule::in(['id', 'categories_id', 'sub_cats_id', 'pd_name', 'pd_stack', 'pd_state', 'created_at']),
        ]);

        $query = Products::query();

        if (request('search')) {
            $query->where('pd_name', 'LIKE', '%'.request('search').'%');
            $query->orWhere('pd_description', 'LIKE', '%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }
        if(request('category')){
            $query->where('categories_id', request('category'));
        }
        if(request('subcat')){
            $query->where('sub_cats_id', request('subcat'));
        }
        $subcat = subCat::all();
        $categories = Categories::all();
        return Inertia::render('Products/Index', [
            'products' => $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString(),
            'filters' => request()->all(['search', 'field', 'direction', 'category', 'subcat']),
            'categories' => $categories,
            'subcat' => $subcat,
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
        $subcat = subCat::all();
        $categories = Categories::all();
        return Inertia::render('Products/Create', [
            'categories' => $categories,
            'subcat' => $subcat,
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
    public function store(ProductsRequest $request)
    {
        $cover = $request->file('cover')->store('ProductsCover', 'public');
        $products = Products::create([
            'pd_name'        => $request->pd_name,
            'pd_price'       => $request->pd_price,
            'pd_stack'       => $request->pd_stack,
            'pd_state'       => $request->pd_state,
            'pd_description' => $request->pd_description,
            'phone'          => substr($request->phone, 1),
            'message'        => $request->message,
            'review'         => $request->review,
            'cover'          => $cover,
            'categories_id'  => $request->categories_id,
            'sub_cats_id'    => $request->sub_cats_id,
        ]);
        foreach($request->file('img_url') as $img){
            $img_name = $img->store('Products', 'public');
            $img_url[] = $img_name;
        }

        for ($i=0 ; $i < count($img_url) ; $i++){
            $products->images()->save(
                Images::make(['img_url' => $img_url[$i]])
            );
        }

        LogsP($request->pd_name, 'اضافة السلعة');

        return Redirect::route('products.index')->with('success', 'تم انشاء سلعة جديدة');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($products)
    {
        $products = new ProductsResources(Products::findOrFail($products));
        $categories = Categories::all();
        $allSubCat = subCat::all();
        $subcat = subCat::where('categories_id', $products->categories_id)->get();
        $products->images;
        return Inertia::render('Products/Edit', [
            'products' => $products,
            'categories' => $categories,
            'subcat' => $subcat,
            'allSubCat' => $allSubCat,
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
    public function update(Request $request, $products)
    {
        $products = Products::findOrFail($products);

        $old_img = array();
        $new_img = array();
        if($request->old_img){
            foreach($request->old_img as $d)
            {
                $old_img[]=$d['img_url'];
            }
        }
        if($products->images){
            foreach($products->images as $d){
                $new_img[]=$d['img_url'];
            }
        }
        if(empty($request->img_url) && empty($request->old_img)){
            $request->validate([
                'img_url' => 'required',
                ],[
                'img_url.required'       => 'يجب ادخال صورة على الاقل',
            ]);
        }elseif(array_diff($new_img, $old_img)){
            foreach(array_diff($new_img, $old_img) as $diff){
                if(Storage::disk('public')->exists($diff)){
                    Storage::disk('public')->delete($diff);
                    Images::where('img_url', $diff)->delete();
                }else{echo "عذرا هنالك خطا";}
            }
        }
    // Begin Validate All Inputs

        if( ($request->pd_name         !== $products->pd_name) ||
            ($request->pd_price        !== $products->pd_price) ||
            ($request->pd_stack        !== $products->pd_stack) ||
            ($request->pd_state        !== $products->pd_state) ||
            ($request->pd_description  !== $products->pd_description) ||
            ($request->phone           !== $products->phone) ||
            ($request->message         !== $products->pd_description) ||
            ($request->review          !== $products->review) ||
            ($request->cover           !== $products->cover) ||
            ($request->categories_id   !== $products->categories_id) ||
            ($request->sub_cats_id     !== $products->sub_cats_id) ||
            ($request->file('img_url') !== null))
        {
            if($request->pd_name !== $products->pd_name){
                $request->validate([
                    'pd_name'        => 'unique:products|required|min:2',
                    ],[
                    'pd_name.required'        => 'يجب ادخال اسم السلعة',
                    'pd_name.unique'          => 'اسم السلعة موجود فعلا',
                    ]
                );
            }
            if($request->pd_price !== $products->pd_price){
                $request->validate([
                    'pd_price'       => 'Numeric|required',
                    ],[
                    'pd_price.Numeric'        => 'يجب ادخال عدد فقط',
                    'pd_price.required'       => 'يجب ادخال سعر السلعة',
                    ]
                );
            }
            if($request->pd_stack !== $products->pd_stack){
                $request->validate([
                    'pd_stack'       => 'Numeric|required',
                    ],[
                    'pd_stack.Numeric'        => 'يجب ادخال عدد فقط',
                    'pd_stack.required'       => 'يجب ادخال المخزن للسلعة',
                    ]
                );
            }
            if($request->pd_description !== $products->pd_description){
                $request->validate([
                    'pd_description'       => 'required|min:5',
                    ],[
                    'pd_description.required'       => 'يجب ادخال وصف للسلعة',
                    'pd_description.min'            => 'يجب ادخال على الاقل 5 حروف للوصف',
                    ]
                );
            }
            if($request->phone !== $products->phone){
                $request->validate([
                    'phone'       => 'required|regex:/(07)[0-9]{9}$/',
                    ],[
                    'phone.regex'        => 'رقم الهاتف يجب ان يتكون من 11 رقم ويبداء بـ 07 وبالانكليزي',
                    'phone.required'       => 'يجب ادخال رقم الهاتف',
                    ]
                );
            }
            if($request->message !== $products->message){
                $request->validate([
                    'message'       => 'required|min:10',
                    ],[
                    'message.required'       => 'يجب ادخال رسالة بدء المحادثة',
                    'message.min'            => 'الرسالة المدخلة قصيرة',
                    ]
                );
            }
            if($request->review !== $products->review){
                $request->validate([
                    'review'       => 'url',
                    ],[
                    'review.url'       => 'يجب ادخال رابط صحيح',
                    ]
                );
            }
            if($request->file('cover') !== null){
                $request->validate([
                    'cover'       => 'required',
                    ],[
                    'cover.required'        => 'يجب ادخال صورة الغلاف للسلعة',
                    ]
                );
                if(Storage::disk('public')->exists($products->cover)){
                    Storage::disk('public')->delete($products->cover);
                }
                $cover = $request->file('cover')->store('ProductsCover', 'public');
            }else{
                $cover = $products->cover;
            }
            if(($request->categories_id   !== $products->categories_id)){
                $request->validate([
                    'categories_id'       => 'required|numeric',
                    ],[
                    'categories_id.required'       => 'يجب اختيار القسم الرئيسي',
                    'categories_id.numeric'       => 'هنالك مشكلة في القسم الرئيسي رجاء اتصل في المبرمج',
                    ]
                );
            }
            if(($request->sub_cats_id   !== $products->sub_cats_id)){
                $request->validate([
                    'sub_cats_id'       => 'required|numeric',
                    ],[
                    'sub_cats_id.required'       => 'يجب اختيار القسم الرئيسي',
                    'sub_cats_id.numeric'       => 'هنالك مشكلة في القسم الرئيسي رجاء اتصل في المبرمج',
                    ]
                );
            }

            $products->update([
                'pd_name' => $request->pd_name,
                'pd_price' => $request->pd_price,
                'pd_stack' => $request->pd_stack,
                'pd_state' => $request->pd_state,
                'pd_description' => $request->pd_description,
                'phone' => substr($request->phone, 1),
                'message' => $request->message,
                'review' => $request->review,
                'cover' => $cover,
                'categories_id' => $request->categories_id,
                'sub_cats_id' => $request->sub_cats_id,
            ]);
            if($request->file('img_url') !== null){
                $request->validate([
                    'img_url.*' => 'mimes:jpeg,jpg,gif,png|max:1000',
                    ],[
                    'img_url.*.mimes'       => 'امتداد الصورة المطلوب : jpeg,jpg,gif,png',
                    'img_url.*.max'       => 'يجب ان لا يتجاوز حجم الصورة 1MB',
                ]);
                for($i = 0; $i < count($request->file('img_url'));$i++){
                    $images = $request->file('img_url')[$i]->store('products', 'public');
                    $products->images()->create(
                        ['img_url' => $images]
                    );
                }
            }
    // End Validate All Inputs
            LogsP($request->pd_name, 'تعديل السلعة');
            return redirect()->route('products.index')->with('success', 'تم تعديل السلعة بنجاح');
        }else{
            return redirect()->route('products.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($products)
    {
        $products = Products::findOrFail($products);
        foreach ($products->images as $images){
            if(file_exists(public_path('storage/' . $images->img_url))){
                unlink(public_path('storage/' . $images->img_url));
            }
        }
        $products->images()->delete();
        if(Storage::disk('public')->exists($products->cover)){
            Storage::disk('public')->delete($products->cover);
        }
        $products->delete();

        LogsP($products->pd_name, 'حذف السلعة');

        return Redirect::route('products.index')->with('success', 'تم الحذف بنجاح');
    }

    public function productsDash(){
        if(request('s') === "special"){
            $subcat = subCat::all();
            $categories = Categories::all();
            return Inertia::render('subCat/Products', [
                'products' => Products::where('pd_state', '1')->paginate(30),
                'categories' => $categories,
                'subcat' => $subcat,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
                'fromDash' => true,
            ]);
        }elseif(request('s') === "empty"){
            $subcat = subCat::all();
            $categories = Categories::all();
            return Inertia::render('subCat/Products', [
                'products' => Products::where('pd_stack', '0')->paginate(30),
                'categories' => $categories,
                'subcat' => $subcat,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
                'fromDash' => true,
            ]);
        }else{
            return abort(404);
        }
    }
}
