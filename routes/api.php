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

    //create user account
    Route::post('register', [UserController::class, 'register']);
    //login
    Route::post('login',[UserController::class,'login'])->name('login')->name('login');




Route::group(['middleware' => ['auth:sanctum']], function () {

    //get all categories from seeker or company
    Route::get('/categories', [CategoryController::class, 'index']);

    //get all category by id from seeker or company
    Route::get('/categories/{category}', [CategoryController::class, 'show']);

    // logout from the app
    Route::post('logout', [UserController::class, 'logout']);


    Route::middleware([SeekerMiddleware::class])->group(function () {

        //show all seekers
        Route::get('/seekers', [SeekerController::class, 'index']);
        //show seeker by id
        Route::get('/seekers/{seeker}', [SeekerController::class, 'show']);
        //create seeker profile
        Route::post('/seekers', [SeekerController::class, 'store']);
        //modify seeker profile
        Route::post('/seekers/{seeker}',[SeekerController::class,'update']);


        //show all freelance posts
        Route::get('/freelance_post',[FreelancePostController::class,'index'])->name('api.freelance_post.index');
        //show  freelance post by id
        Route::get('/freelance_post/{freelancePost}', [FreelancePostController::class, 'show'])->name('api.freelance_post.show');
        //add freelance post from seeker
        Route::post('/freelance_post', [FreelancePostController::class, 'store'])->name('api.freelance_post.store');
        //modify the freelance post
        Route::post('/freelance_post/{freelancePost}',[FreelancePostController::class,'update'])->name('api.freelance_post.update');

        Route::get('/seeker_post/{seeker}',[FreelancePostController::class,'getFreelancePosts'])->name('api.freelance_post.index');


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


