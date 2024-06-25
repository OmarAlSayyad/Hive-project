<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\SeekerMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');



Route::post('register', [UserController::class, 'register']);
Route::post('login',[UserController::class,'login'])->name('login')->name('login');




Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('logout', [UserController::class, 'logout']);


    Route::middleware([SeekerMiddleware::class])->group(function () {
        Route::post('/createSeekerProfile', [SeekerController::class, 'store']);
        Route::get('/get-all-Seeker', [SeekerController::class, 'index']);
        Route::get('/get_seeker_by_id/{seeker}', [SeekerController::class, 'show']);

    });
    Route::middleware([CompanyMiddleware::class])->group(function (){

        Route::get('/companies',[CompanyController::class,'index'])->name('api.companies.index');
        Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('api.companies.show');
        Route::post('/companies',[CompanyController::class,'store'])->name('api.companies.store');
        Route::put('/companies/{company}',[CompanyController::class,'update'])->name('api.companies.update');


    });


});


