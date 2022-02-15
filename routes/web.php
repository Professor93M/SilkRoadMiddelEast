<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubCatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsControllerWeb;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CarouselController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LogsController;
use App\Models\Carousel;
use App\Models\Categories;
use App\Models\Orders;
use App\Models\Products;
use App\Models\subCat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        // 'canRegister' => Route::has('register'),
    ]);
});

Route::get('/dashboard', function () {
    $orders = Orders::where('state', '0')->orderBy('created_at', 'desc')->get();
    $ids = array();
    $count = 0;
    if(count($orders) > 0){
        for ($i = 0; $i < count($orders); $i++){
            if(!in_array($orders[$i]->carts_id, $ids)){
                $count++;
                array_push($ids, $orders[$i]->carts_id);
            }
        }
    }
    return Inertia::render('Dashboard', [
        'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
        'products' => Products::count(),
        'speical' => Products::where('pd_state', 1)->count(),
        'stack' => Products::where('pd_stack', '<=', '0')->count(),
        'categories' => Categories::count(),
        'subCats' => subCat::count(),
        'carOff' => Carousel::where('state', '0')->count(),
        'carOn' => Carousel::where('state', '1')->count(),
        'newOrder' => orderCount(),
        'doneOrder' => doneOrders('1'),
        'saveOrder' => Orders::where('state', '2')->count(),
        'orderCount' => orderCount(),
    ]);
})->middleware(['auth'])->name('dashboard');


// +++++ Home Routes ++++++
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/likes', [HomeController::class, 'favorite']);
Route::get('/special', [HomeController::class, 'special']);
Route::get('/category', [HomeController::class, 'allCategories']);
Route::get('/category/{id}', [HomeController::class, 'subCats']);
Route::get('/subcats/{id}', [HomeController::class, 'subCat']);
Route::get('/product', [HomeController::class, 'allProducts']);
Route::get('/product/{products_id}', [HomeController::class, 'product']);
Route::get('/cart', [HomeController::class, 'cart']);
Route::post('/saveCarts', [HomeController::class, 'saveCarts']);
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/state', [HomeController::class, 'state'])->name('state');
Route::get('/stateCheck', [HomeController::class, 'stateCheck'])->name('stateCheck');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// +++++ Dashboard Routes ++++++
Route::Resource('/products', ProductsControllerWeb::class)->middleware('auth:sanctum');
Route::Resource('/categories', CategoriesController::class)->middleware('auth:sanctum');
Route::Resource('/subcat', SubCatController::class)->middleware('auth:sanctum');
Route::Resource('/carousel', CarouselController::class)->middleware('auth:sanctum');

// Route::get('dashboard', [ProductsControllerWeb::class, 'productsDash'])->middleware('auth:sanctum');
Route::prefix('dashboard')->middleware('auth:sanctum')->group(function () {
    Route::get('/products', [ProductsControllerWeb::class, 'productsDash'])->name('productsDash');
    Route::get('/carousel', [CarouselController::class, 'carouselDash'])->name('carouselDash');
});
Route::prefix('orders')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [OrdersController::class, 'index'])->name('orders.index');
    Route::get('/checked', [OrdersController::class, 'checked'])->name('orders.checked');
    Route::get('/history', [OrdersController::class, 'history'])->name('orders.history');
    Route::get('/{order}/show', [OrdersController::class, 'show'])->name('orders.show');
    Route::post('/', [OrdersController::class, 'changeState']);
    Route::delete('/{id}', [OrdersController::class, 'delete']);

    Route::get('/{any}', function(){
        return abort(404);
    });
});
// Route::any('/{any}', function(){
//     return abort(404);
// });
// ++++++ Images Route ++++++
Route::get('/images/{folder}/{image}', [ImageController::class, 'all']);
Route::get('categories/{id}/images/{folder}/{image}', [ImageController::class, 'cats']);
Route::get('categories/images/{folder}/{image}', [ImageController::class, 'subcategories']);
Route::get('subcat/{id}/images/{folder}/{image}', [ImageController::class, 'subcatid']);
Route::get('subcat/images/{folder}/{image}', [ImageController::class, 'subcat']);
Route::get('subcats/images/{folder}/{image}', [ImageController::class, 'subcats']);
Route::get('category/images/{folder}/{image}', [ImageController::class, 'cat']);
Route::get('products/{id}/images/{folder}/{image}', [ImageController::class, 'prod']);
Route::get('product/images/{folder}/{image}', [ImageController::class, 'products']);
Route::get('carousel/{id}/images/{folder}/{image}', [ImageController::class, 'car']);
Route::get('dashboard/images/{folder}/{image}', [ImageController::class, 'dash']);



require __DIR__.'/auth.php';
