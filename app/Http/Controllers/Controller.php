<?php

namespace App\Http\Controllers;

use App\Models\logs;
use App\Models\Orders;
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


function LogsUsers($req, $text){
    logs::create([
        'log' => $text . ' ('. $req .')',
        'username' => Auth::user()->name,
        'isUser' => 2,
    ]);
}

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
                    ],[
                    'name.required'        => 'يجب ادخال اسم للمشرف',
                ]);
            }
            if($request->email !== $admin->email){
                $request->validate([
                    'email' => 'required|unique:users|email'
                    ],[
                    'email.required'        => 'يجب ادخال البريد الالكتروني',
                    'email.unique'        => 'البريد الالكتروني مستخدم',
                    'email.email'        => 'البريد الالكتروني المدخل غير صالح',
                ]);
            }
            if($request->password !== $admin->password && $request->password !== null){
                $request->validate([
                    'password' => ['required', 'confirmed', Rules\Password::min(8)],
                    ],[
                    'password.required'  => 'يجب ادخال كلمة المرور',
                    'password.confirmed' => 'كلمة المرور غير متطابقة',
                    // 'password'       => 'يجب ادخال على الاقل 8 حروف او رموز او ارقام',
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
            LogsUsers($request->name, 'تحديث بيانات');
            return Redirect::route('admin.index')->with('success', 'تم تعديل بيانات المشرف بنجاح');
        }else{
            return Redirect::route('admin.index');
        }
    }

    public function delete($id)
    {
        $admin = User::findOrFail($id);
        LogsUsers($admin->name, 'حذف المشرف');
        $admin->delete();
        return Redirect::route('admin.index')->with('success', 'تم حذف المشرف بنجاح');
    }

}
