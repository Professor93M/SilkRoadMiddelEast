<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/admins/{any}', function(){
    return abort(404);
});
Route::get('/admins', [Controller::class, 'index'])
                ->middleware(['auth', 'admin'])
                ->name('admin.index');

Route::get('/admins/{id}/edit', [Controller::class, 'edit'])
                ->middleware(['auth', 'admin'])
                ->name('admin.edit');

Route::put('/admins/{id}', [Controller::class, 'update'])
                ->middleware(['auth', 'admin'])
                ->name('admin.update');

Route::get('/admins/{id}', [Controller::class, 'delete'])
                ->middleware(['auth', 'admin'])
                ->name('admin.delete');

Route::get('/register', [RegisteredUserController::class, 'create'])
                ->middleware(['guest'])
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware(['guest']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');
