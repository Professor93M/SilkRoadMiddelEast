<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Carousel;
use App\Models\subCat;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'Category' => Categories::orderBy('created_at', 'asc')->with('image')->get(),
            'ProdLastest' => Products::orderBy('created_at', 'desc')->with('images')->limit(20)->get(),
            'carousel' => Carousel::where('state', '1')->with('image')->get(),
            'Special' => Products::where('pd_state', '1')->orderBy('created_at', 'desc')->with('images')->limit(20)->get(),
        ]);
    }
    public function favorite()
    {
        return Inertia::render('favorite', [
            'favorite' => Products::with('images')->get(),
        ]);
    }
    public function special()
    {
        return Inertia::render('special', [
            'special' => Products::where('pd_state', '1')->orderBy('created_at', 'desc')->with('images')->paginate(24),
        ]);
    }
    public function category()
    {
        $categories_id = request('categories_id');
        return Inertia::render('category', [
            'category' => Products::where('categories_id', $categories_id)->with('images')->paginate(24),
            'cat_name' => Categories::select('cat_name')->where('id', $categories_id)->first()
        ]);
    }
    public function allCategories()
    {
        return Inertia::render('Category/allCategories', [
            'allCategories' => Categories::orderBy('created_at', 'desc')->with('image')->paginate(24)
        ]);
    }

    public function subCats($id)
    {
        $cat_name = Categories::findOrFail($id);
        return Inertia::render('Category/subCats', [
            'subCats' => subCat::where('categories_id', $id)->with('image')->paginate(24),
            'cat_name' => $cat_name->cat_name,
        ]);
    }
    public function subCat($id)
    {
        $subcat = subCat::findOrFail($id);
        return Inertia::render('Category/Products', [
            'products' => Products::where('sub_cats_id', $id)->orderBy('created_at', 'desc')->paginate(24),
            'subcat' => $subcat,
            'categories_name' => Categories::where('id', $subcat->categories_id)->first('cat_name'),
        ]);
    }
    public function product()
    {
        Products::count() > 24 ? $prod = 24 : $prod = Products::count() -1;
        $products_id = request('products_id');
        $product = Products::findOrFail($products_id);
        $products = Products::with('images')->findOrFail($products_id);
        $related = Products::with('images')->where('id', '!=', $products_id)->get()->random($prod)->shuffle();
        $others = Products::with('images')->where('id', '!=', $products_id)->where('categories_id', $product->categories_id)->get()->shuffle();

        return Inertia::render('product', [
            'cover' => $products->cover,
            'description' => $products->pd_description,
            'title' => $products->pd_name,
            'products' => $related,
            'others' => $others,
            'product' => $products,
            'cat_name' => Categories::select('cat_name')->where('id', $product->categories_id)->first(),
            'subcat_name' => subCat::select('cat_name')->where('id', $product->sub_cats_id)->first()
        ]);
    }
    public function allProducts()
    {
        return Inertia::render('allProducts', [
            'allProducts' => Products::orderBy('created_at', 'desc')->with('images')->paginate(24)
        ]);
    }
    public function cart(){
        return Inertia::render('cart', [
            'carts' => Products::with('images')->get(),
        ]);
    }

    public function saveCarts(Request $request){
        $validator = Validator::make($request->all()[0], [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => 'nullable|email',
            'mobile' => 'required',
            'mobile2' => 'nullable|different:mobile',
            'country' => 'required',
            'address' => 'required|min:5',
            'location' => 'required',
            'comment' => 'nullable',
        ]);
        if ($validator->fails()) {
            return redirect('/cart')
                ->withErrors($validator)
                ->withInput();
        }
        $cart = Cart::create([
            'first_name'    => $request->input('0.first_name'),
            'last_name'     => $request->input('0.last_name'),
            'email'         => $request->input('0.email'),
            'mobile'        => $request->input('0.mobile'),
            'mobile2'       => $request->input('0.mobile2'),
            'country'   => $request->input('0.country'),
            'address'       => $request->input('0.address'),
            'location'      => $request->input('0.location'),
            'comment'       => $request->input('0.comment'),
        ]);
        for ($i=0;$i<count($request->input('1.pd_name'));$i++){
            Orders::create([
                'or_name' => $request->input('1.pd_name')[$i],
                'or_price' => $request->input('1.pd_price')[$i],
                'count' => $request->input('1.count')[$i],
                'cart_id' => $cart->id,
                'products_id' => $request->input('1.id')[$i],
            ]);
        }

        return Redirect::route('home')->with('success', 'Purchased done Successfuly, Order No. ( '. $cart->id .' ) try to save it.');
    }

    public function search(){
        $searched = Products::where('pd_name', 'LIKE', '%' . request('s') . '%')
                        ->orWhere('pd_description', 'LIKE', '%' . request('s') . '%')
                        ->orWhere('company', 'LIKE', '%' . request('s') . '%')->with('images')->paginate(24);
        if($searched->total() > 0){
            return Inertia::render('search', [
                'searched' => $searched
            ]);
        }else{
            return redirect()->route('home');
        }
    }

    public function state(){
        return Inertia::render('state');
    }

    public function stateCheck(){
        $mobile = Validator::make(request()->all(), [
                'm' => 'required'
            ]);
        if ($mobile->fails()) {
            return redirect('/state')
                        ->withErrors($mobile)
                        ->withInput();
        }
        $mobile = $mobile->validated();

        $orders = DB::table('carts')->leftJoin('orders', 'carts.id', '=', 'orders.cart_id')
                    ->where('carts.mobile', $mobile)
                    ->where(function($q){
                        $q->where('orders.state', '<=', 1);
                    })
                    ->orWhere('carts.mobile2', $mobile)
                    ->where(function($q){
                        $q->where('orders.state', '<=', 1);
                    })->orderBy('orders.created_at', 'desc')->first();

        if(!empty($orders)){
            return Inertia::render('stateCheck', [
                'orders' => $orders
            ]);
        }else{
            return Redirect::route('state')->with('success', 'There is no order for entered Mobile Number (  '. request('m') .'  )');
        }
    }

    public function contact(){
        return Inertia::render('contact');
    }
}
