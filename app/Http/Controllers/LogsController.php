<?php

namespace App\Http\Controllers;

use App\Models\logs;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

function Logs($req, $text){
    logs::create([
        'log' => $text . ' ('. $req .')',
        'username' => Auth::user()->name,
        'isUser' => 2,
    ]);
}

class LogsController extends Controller
{
    public function index(){
        request()->validate([
            'direction' => Rule::in(['asc', 'desc']),
            'field'     => Rule::in(['username', 'created_at']),
        ]);

        $query = logs::query();

        if (request('search')) {
            $query->where('username', 'LIKE', '%'.request('search').'%');
            $query->orWhere('log', 'LIKE', '%'.request('search').'%');
        }
        if(request()->has(['field', 'direction'])){
            $query->orderBy(request('field'), request('direction'));
        }
        return Inertia::render('Logs/Index', [
            'logs' => $query->orderBy('created_at', 'desc')->where('isUser', '2')->paginate(30),
            'filters' => request()->all(['search', 'field', 'direction']),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
            'search' => true,
        ]);
    }
    public function usersLog(){
        return Inertia::render('Logs/usersLog', [
            'logs' => logs::where()->orderBy('created_at', 'desc')->paginate(30),
            'filters' => request()->all(['search', 'field', 'direction']),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
            'search' => true,
        ]);
    }

    public function destroy($id){
        $products = logs::findOrFail($id);
        $products->delete($id);
        // LogsUsers($products->username, 'حذف سجل لـ');
        return Redirect::back();
    }

    public function destroyAll(){
        $logs = logs::where('isUser', 2)->get();
        logs::destroy($logs);
        // LogsUsers('السجل', 'قام بتنظيف');
        return Redirect::back();
    }

    public function show($name){
        // request()->validate([
        //     'direction' => Rule::in(['asc', 'desc']),
        //     'field'     => Rule::in(['username', 'log']),
        // ]);

        // $query = logs::query();

        // if(request('search')) {
        //     $query->where('username', 'LIKE', '%'.request('search').'%');
        //     $query->orWhere('log', 'LIKE', '%'.request('search').'%');
        // }

        // if(request()->has(['field', 'direction'])){
        //     $query->orderBy(request('field'), request('direction'));
        // }

        return Inertia::render('Logs/Index', [
            'logs' => logs::orderBy('created_at', 'desc')->where('username', $name)->where('isUser', '2')->paginate(30),
            'filters' => request()->all(['field', 'direction']),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
            'search' => false,
        ]);
    }

    public function usersLogs(){
        return Inertia::render('Logs/usersLogs', [
            'logs' => logs::orderBy('created_at', 'desc')->where('isUser', '1')->paginate(30),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
            'search' => false,
        ]);
    }

    public function deleteUsersLogs($id){
        $products = logs::findOrFail($id);
        $products->delete($id);
        // LogsUsers($products->username, 'حذف تحقق الرقم');
        return Redirect::back();
    }

    public function deleteAllUsersLogs(){
        $logs = logs::where('isUser', 1)->get();
        logs::destroy($logs);
        LogsUsers('سجل المستخدمين', 'قام بتنظيف');
        return Redirect::back();
    }
}
