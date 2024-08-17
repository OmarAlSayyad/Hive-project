<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
Route::post('login',[UserController::class,'login'])->name('login');


Route::get('/', 'App\Http\Controllers\AdminController@index');
Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications')->middleware('auth');
;
Route::get('/admin/add', 'App\Http\Controllers\AdminController@create')->name('admin.create');
Route::post('/admin/store', 'App\Http\Controllers\AdminController@store')->name('admin.store');
Route::get('/users', 'App\Http\Controllers\UserController@cat')->name('users.index');
Route::get('/users/{id}/permissions', [UserController::class, 'getUserPermissions'])->name('users.permissionusers');
Route::patch('/users/{user}/toggleBan', [UserController::class, 'toggleBan'])->name('users.toggleBan');
Route::patch('/users/{user}/toggleApproval', [UserController::class, 'toggleApproval'])->name('users.toggleApproval');






Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
