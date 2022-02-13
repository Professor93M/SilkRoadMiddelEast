<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LogsController;
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
                ->middleware(['auth', 'admin'])
                ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
                ->middleware(['auth', 'admin']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware('guest')
                ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
                ->middleware('guest');

Route::get('/logs', [LogsController::class, 'index'])->middleware(['auth', 'admin']);
Route::get('/logs/users', [LogsController::class, 'usersLog'])->middleware(['auth', 'admin']);
Route::delete('/logs/{id}/destroy', [LogsController::class, 'destroy'])->middleware(['auth', 'admin']);
Route::delete('/logs/destroyall', [LogsController::class, 'destroyAll'])->middleware(['auth', 'admin']);
Route::get('/logs/{name}/show', [LogsController::class, 'show'])->middleware(['auth', 'admin']);



// Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
//                 ->middleware('guest')
//                 ->name('password.request');

// Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
//                 ->middleware('guest')
//                 ->name('password.email');

// Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//                 ->middleware('guest')
//                 ->name('password.reset');

// Route::post('/reset-password', [NewPasswordController::class, 'store'])
//                 ->middleware('guest')
//                 ->name('password.update');

// Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
//                 ->middleware('auth')
//                 ->name('verification.notice');

// Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//                 ->middleware(['auth', 'signed', 'throttle:6,1'])
//                 ->name('verification.verify');

// Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
//                 ->middleware(['auth', 'throttle:6,1'])
//                 ->name('verification.send');

// Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
//                 ->middleware('auth')
//                 ->name('password.confirm');

// Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
//                 ->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->middleware('auth')
                ->name('logout');
