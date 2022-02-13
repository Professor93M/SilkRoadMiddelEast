<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Cart;
use App\Models\logs;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

function LogsO($req, $text){
    logs::create([
        'log' => $text . ' ('. $req .')',
        'username' => Auth::user()->name,
        'isUser' => 2,
    ]);
}

class OrdersController extends Controller
{
    public function index(){
        $orders = Orders::where('state', '0')->orderBy('created_at', 'desc')->get();
        $ids = array();
        $index = 0;

        if(count($orders) > 0){
            for ($i = 0; $i < count($orders); $i++){
                if(!in_array($orders[$i]->cart_id, $ids)){
                    $order[$index] = Cart::where('id', $orders[$i]->cart_id)->with('orders')->first();
                    array_push($ids, $orders[$i]->cart_id);
                    $index++;
                }
            }
            return Inertia::render('Orders/Index', [
                'orders' => $order,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
        }else{
            return Inertia::render('Orders/Index', [
                'orders' => null,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
        }
    }

    public function show($order){
        $cart = Cart::findOrFail($order);
        $orders = Orders::where('cart_id', $cart->id)->get();
        return Inertia::render('Orders/Show', [
            'orders' => $orders,
            'cart' => $cart,
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    public function changeState(){
        if(request('state') === 1){
            $cart = Cart::findOrFail(request('id'));
            $orders = Orders::where('cart_id', $cart->id)->get('state');
            $orders = Orders::whereIn('state', $orders)->where('cart_id', $cart->id)->update(array('state' => 1));
            LogsO($cart->first_name . ' ' . $cart->last_name, 'تجهيز طلب');

            return redirect()->route('orders.index')->with('success', 'تم تجهيز الطلب بنجاح');
        }elseif(request('state') === 2){
            $cart = Cart::findOrFail(request('id'));
            $products = Products::all();
            $orders = Orders::where('cart_id', $cart->id)->get('state');
            $order = Orders::where('cart_id', $cart->id)->get();
            $orders = Orders::whereIn('state', $orders)->where('cart_id', $cart->id)->update(array('state' => 2));
            for($i=0;$i < count($products);$i++){
                for($j=0;$j < count($order);$j++){
                    if($order[$j]->pd_id === $products[$i]->products_id){
                        Products::find($products[$i]->id)->decrement('pd_stack', $order[$j]->count);
                    }
                }
            }
            LogsO($cart->first_name . ' ' . $cart->last_name, 'تخزين طلب');

            return redirect()->route('orders.checked')->with('success', 'تم تخزين الطلب بنجاح');
        }elseif(request('state') === 3){
            $cart = Cart::findOrFail(request('id'));
            $orders = Orders::where('cart_id', $cart->id)->get('state');
            $orders = Orders::whereIn('state', $orders)->where('cart_id', $cart->id)->update(array('state' => 0));
            LogsO($cart->first_name . ' ' . $cart->last_name, 'تراجع عن تجهيز طلب');

            return redirect()->route('orders.checked')->with('success', 'تم التراجع عن التجهيز بنجاح');
        }
        // elseif(request('state') === 4){
        //     $cart = Cart::findOrFail(request('id'));
        //     $orders = Orders::where('cart_id', $cart->id)->get('state');
        //     $orders = Orders::whereIn('state', $orders)->where('cart_id', $cart->id)->update(array('state' => 1));
        //     LogsO($cart->first_name . ' ' . $cart->last_name, 'تراجع عن حفظ طلب');

        //     return redirect()->route('orders.history')->with('success', 'تم التراجع عن الحفظ بنجاح');
        // }
    }

    public function delete($id){
        $cart = Cart::findOrFail($id);
        $cart->delete();
        LogsO($cart->first_name . ' ' . $cart->last_name, 'حذف طلب');

        return Redirect::route('orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }

    public function checked(){
        $orders = Orders::where('state', '1')->orderBy('created_at', 'desc')->get();
        $ids = array();
        $index = 0;

        if(count($orders) > 0){
            for ($i = 0; $i < count($orders); $i++){
                if(!in_array($orders[$i]->cart_id, $ids)){
                    $order[$index] = Cart::where('id', $orders[$i]->cart_id)->with('orders')->first();
                    array_push($ids, $orders[$i]->cart_id);
                    $index++;
                }
            }

            return Inertia::render('Orders/Checked', [
                'orders' => $order,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
        }else{
            return Inertia::render('Orders/Checked', [
                'orders' => null,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
        }
    }

    public function history(){
        $orders = Orders::where('state', '2')->orderBy('created_at', 'desc')->get();
        $ids = array();
        $index = 0;

        if(count($orders) > 0){
            for ($i = 0; $i < count($orders); $i++){
                if(!in_array($orders[$i]->cart_id, $ids)){
                    $order[$index] = Cart::where('id', $orders[$i]->cart_id)->with('orders')->first();
                    array_push($ids, $orders[$i]->cart_id);
                    $index++;
                }
            }
            return Inertia::render('Orders/History', [
                'orders' => $order,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
        }else{
            return Inertia::render('Orders/History', [
                'orders' => null,
                'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
        }
    }
}
