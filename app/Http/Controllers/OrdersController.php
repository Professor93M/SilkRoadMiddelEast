<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Cart;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

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
            return redirect()->route('orders.index')->with('success', 'Order has been processed successfully');
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

            return redirect()->route('orders.checked')->with('success', 'Stored Successfuly');
        }elseif(request('state') === 3){
            $cart = Cart::findOrFail(request('id'));
            $orders = Orders::where('cart_id', $cart->id)->get('state');
            $orders = Orders::whereIn('state', $orders)->where('cart_id', $cart->id)->update(array('state' => 0));
            return redirect()->route('orders.checked')->with('success', 'Backforward Successfuly');
        }
    }

    public function delete($id){
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return Redirect::route('orders.index')->with('success', 'Order Deleted Successfuly');
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
