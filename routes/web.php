<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceAndCityController;
use App\Http\Controllers\RegisterFormController;
use App\Http\Controllers\RegisterListController;
use App\Http\Controllers\UserListController;
use App\Http\Middleware\AdminAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/register-form', function () {
        return view('register.form');
    })->name('register-form');

    Route::get('/provinces-and-cities/get-all-provinces', [ProvinceAndCityController::class, 'getAllProvinces']);
    Route::get('/provinces-and-cities/get-all-cities/{provinceName}', [ProvinceAndCityController::class, 'getAllCities']);
    Route::post('/register-form', [RegisterFormController::class, 'store'])->name('register-form.store');

});

Route::middleware(AdminAuth::class)->group(function(){


    Route::get('list-register', [RegisterListController::class, 'index'])->name('admin.list-register');
    Route::get('edit-register/{id}', [RegisterListController::class, 'edit'])->name('admin.edit-register');
    Route::patch('edit-register/{id}', [RegisterListController::class, 'update'])->name('admin.update-register');
    Route::get('delete-register/{id}', [RegisterListController::class, 'delete'])->name('admin.delete-register');

    
    Route::get('add-user', [UserListController::class, 'create'])->name('admin.add-user');
    Route::post("add-user", [UserListController::class, 'store'])->name('admin.add-user');
    Route::get('list-user', [UserListController::class, 'index'])->name('admin.list-user');
    Route::get('delete-user/{id}', [UserListController::class, 'delete'])->name('admin.delete-user');
    Route::get('edit-user/{id}', [UserListController::class, 'edit'])->name('admin.edit-user');
    Route::patch('edit-user/{id}', [UserListController::class, 'update'])->name('admin.update-user');
});

require __DIR__.'/auth.php';