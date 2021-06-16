<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserActivityMiddleware;

Route::get('/', function () {
    return redirect(route('login'));
});
Route::get('/home', HomeController::class);
Route::get('/blocked', static function () {
    return view('blockedMessage');
})->name('blocked');

## AUTH ROUTES
Route::get('login', [Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [Auth\LoginController::class, 'login']);
Route::post('logout', [Auth\LoginController::class, 'logout'])->name('logout');
//Route::get('register', [Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
//Route::post('register', [Auth\RegisterController::class, 'register']);
Route::middleware(UserActivityMiddleware::class)->get('check-activity', UserActivityController::class);
## END AUTH ROUTES

Route::middleware('auth')->resource('products', 'ProductController');

Route::middleware('auth')->get('/user/', [UserController::class, 'menu'])->name('user.menu');

Route::middleware('auth')->get('/admin/', [AdminController::class, 'menu'])->name('admin.menu');
Route::middleware('auth')->get('/admin/all-users', [AdminController::class, 'getAllUsers'])->name('admin.allUsers');
Route::middleware('auth')->post('/admin/change-role', [AdminController::class, 'changeRole'])->name('admin.changeRole');
Route::middleware('auth')->post('/admin/block-user', [AdminController::class, 'blockUser'])->name('admin.blockUser');

Route::middleware('auth')->get('/admin/create-user', [AdminController::class, 'createUser'])->name('admin.createUser');
Route::middleware('auth')->post('/admin/create-user', [AdminController::class, 'storeUser'])->name('admin.storeUser');
