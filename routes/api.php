<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FreelancePostController;
use App\Http\Controllers\JobPostController;
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
//add freelance post from seeker or company
    Route::post('/add_freelancePost', [FreelancePostController::class, 'store']);

//get categories from seeker or company
    Route::get('/get-all-categories', [CategoryController::class, 'index']);
    Route::get('/get-category-by-id/{category}', [CategoryController::class, 'show']);

    // logout from the app
    Route::post('logout', [UserController::class, 'logout']);


    Route::middleware([SeekerMiddleware::class])->group(function () {
        Route::post('/createSeekerProfile', [SeekerController::class, 'store']);
        Route::get('/get-all-Seeker', [SeekerController::class, 'index']);
        Route::get('/get_seeker_by_id/{seeker}', [SeekerController::class, 'show']);
        Route::post('/seekers/{seeker}',[SeekerController::class,'update']);

    });
    Route::middleware([CompanyMiddleware::class])->group(function (){

        Route::get('/companies',[CompanyController::class,'index'])->name('api.companies.index');
        Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('api.companies.show');
        Route::post('/companies',[CompanyController::class,'store'])->name('api.companies.store');
        Route::post('/companies/{company}',[CompanyController::class,'update'])->name('api.companies.update');

        Route::get('/job-post',[JobPostController::class,'index'])->name('api.job_post.index');
        Route::get('/job-post/{jobPost}', [JobPostController::class, 'show'])->name('api.job_post.show');
        Route::get('/job-post/company/{company}', [JobPostController::class, 'companyJobPost'])->name('api.job_post.companyJobPost');
        Route::post('/job-post',[JobPostController::class,'store'])->name('api.job_post.store');
        Route::post('/job-post/{jobPost}',[JobPostController::class,'update'])->name('api.job_post.update');



    });


});


