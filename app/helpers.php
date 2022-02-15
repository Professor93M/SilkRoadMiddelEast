<?php

use App\Models\Orders;
use App\Models\Cart;

if (!function_exists('doneOrders')) {
    function doneOrders($state){
        $orders = Orders::where('state', $state)->get();
        $ids = array();
        $index = 0;
        if(count($orders) > 0){
            for ($i = 0; $i < count($orders); $i++){
                if(!in_array($orders[$i]->cart_id, $ids)){
                    $order[$index] = Cart::where('id', $orders[$i]->cart_id)->first();
                    array_push($ids, $orders[$i]->cart_id);
                    $index++;
                }
            }
            return count($order);
        }else{
            return 0;
        }
    }
}

if (!function_exists('orderCount')) {
    function orderCount(){
        $orders = Orders::where('state', '0')->orderBy('created_at', 'desc')->get();
        $ids = array();
        $count = 0;
        if(count($orders) > 0){
            for ($i = 0; $i < count($orders); $i++){
                if(!in_array($orders[$i]->cart_id, $ids)){
                    $count++;
                    array_push($ids, $orders[$i]->cart_id);
                }
            }
        }
        return $count;
    }
}

