<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        return Inertia::render('Admins/Index', [
            'admins' => User::orderBy('created_at', 'desc')->paginate(15),
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    public function edit($id)
    {
        $admins = User::findOrFail($id);
        return Inertia::render('Admins/Edit', [
            'admins' => $admins,
            'isAdmin' => Auth::user()->isAdmin == 1 ? 1 : 0,
            'orderCount' => orderCount(),
            'doneOrder' => doneOrders('1'),
        ]);
    }

    public function update(Request $request, $id){
        $admin = User::findOrFail($id);
        if(($request->name !== $admin->name) || ($request->email !== $admin->email) || ($request->password !== $admin->password) || ($request->isAdmin !== $admin->isAdmin)){
            if($request->name !== $admin->name){
                $request->validate([
                    'name' => 'required'
                ]);
            }
            if($request->email !== $admin->email){
                $request->validate([
                    'email' => 'required|unique:users|email'
                ]);
            }
            if($request->password !== $admin->password && $request->password !== null){
                $request->validate([
                    'password' => ['required', 'confirmed', Rules\Password::min(8)],
                ]);
            }

            // dd(isset($request->password));
            $admin->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => !isset($request->password) ? $admin->password : Hash::make($request->password),
                'isAdmin' => $request->isAdmin,
                'orderCount' => orderCount(),
                'doneOrder' => doneOrders('1'),
            ]);
            return Redirect::route('admin.index')->with('success', 'Updated Successfuly');
        }else{
            return Redirect::route('admin.index');
        }
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();
        return Redirect::route('admin.index')->with('success', 'Deleted Successfuly');
    }

}
