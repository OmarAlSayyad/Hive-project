<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FreelancePostController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\SeekerMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WalletController;

Route::post('/wallet/fill', [WalletController::class, 'fillWallet']);
Route::get('/wallet/process-payments', [WalletController::class, 'processAutomaticPayments']);


//create user account
Route::post('register', [UserController::class, 'register'])->name('register');
//login
Route::post('login',[UserController::class,'login'])->name('login');




Route::group(['middleware' => ['auth:sanctum']], function () {

    // logout from the app
    Route::post('logout', [UserController::class, 'logout'])->name('logout');




    //get all categories from seeker or company
    Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.index');
    //get all category by id from seeker or company
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('api.categories.show');


    //show all seekers
    Route::get('/seekers', [SeekerController::class, 'index'])->name('api.seekers.index');
    //show seeker by id
    Route::get('/seekers/{seeker}', [SeekerController::class, 'show'])->name('api.seekers.show');


    // company
    Route::get('/companies',[CompanyController::class,'index'])->name('api.companies.index');
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('api.companies.show');
    Route::get('/job-post/company/{company}', [JobPostController::class, 'companyJobPost'])->name('api.job_post.companyJobPost');


    //show all freelance posts
    Route::get('/freelance_post',[FreelancePostController::class,'index'])->name('api.freelance_post.index');
    //show  freelance post by id
    Route::get('/freelance_post/{freelancePost}', [FreelancePostController::class, 'show'])->name('api.freelance_post.show');
    // show all seeker posts by id
    Route::get('/seeker_posts_by_id/{seeker}',[FreelancePostController::class,'getFreelancePostsById'])->name('api.freelance_post.getFreelancePostsById');



    Route::get('/job-post',[JobPostController::class,'index'])->name('api.job_post.index');
    Route::get('/job-post/{jobPost}', [JobPostController::class, 'show'])->name('api.job_post.show');


    Route::middleware([SeekerMiddleware::class])->group(function () {



        //get seeker profile
        Route::get('/get_seeker_profile',[SeekerController::class,'getMySeeker'])->name('api.seekers.getMySeeker');
        //create seeker profile
        Route::post('/seekers', [SeekerController::class, 'store'])->name('api.seekers.store');
        //modify seeker profile
        Route::post('/update_seeker_profile',[SeekerController::class,'update'])->name('api.seekers.update');
        //delete seeker profile
       Route::delete('/seekers',[SeekerController::class,'destroy'])->name('api.seekers.destroy');


        // show all seeker posts
        Route::get('/seeker_posts',[FreelancePostController::class,'getFreelancePosts'])->name('api.freelance_post.getFreelancePosts');
        //add freelance post from seeker
        Route::post('/freelance_post', [FreelancePostController::class, 'store'])->name('api.freelance_post.store');
        //modify the freelance post
        Route::post('/freelance_post/{freelancePost}',[FreelancePostController::class,'update'])->name('api.freelance_post.update');
        //delete freelance post
        Route::delete('/freelance_post/{freelancePost}',[FreelancePostController::class,'destroy'])->name('api.freelance_post.destroy');

    });
    Route::middleware([CompanyMiddleware::class])->group(function (){


        Route::get('/my-profile-company',[CompanyController::class,'getMyCompany'])->name('api.companies.getMyCompany');
        Route::post('/companies',[CompanyController::class,'store'])->name('api.companies.store');
        Route::post('/companies/{company}',[CompanyController::class,'update'])->name('api.companies.update');

        Route::get('/job-post',[JobPostController::class,'index'])->name('api.job_post.index');
        Route::get('/job-post/{jobPost}', [JobPostController::class, 'show'])->name('api.job_post.show');
        Route::get('/job-post/company/{company}', [JobPostController::class, 'companyJobPost'])->name('api.job_post.companyJobPost');
        Route::post('/job-post',[JobPostController::class,'store'])->name('api.job_post.store');
        Route::post('/job-post/{jobPost}',[JobPostController::class,'update'])->name('api.job_post.update');
        Route::delete('/job-post/{jobPost}',[JobPostController::class,'destroy'])->name('api.job_post.destroy');


        Route::get('/freelance_post',[FreelancePostController::class,'index'])->name('api.freelance_post.index');
        Route::get('/freelance_post/{freelancePost}', [FreelancePostController::class, 'show'])->name('api.freelance_post.show');
        Route::post('/freelance_post', [FreelancePostController::class, 'store'])->name('api.freelance_post.store');
        Route::post('/freelance_post/{freelancePost}',[FreelancePostController::class,'update'])->name('api.freelance_post.update');



    });


});
