<?php

use App\Http\Controllers\ApplicantsFreelancePostController;
use App\Http\Controllers\ApplicantsJobPostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\FavoriteFreelanceController;
use App\Http\Controllers\FavoriteJobController;
use App\Http\Controllers\FreelancePostController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\JobPostController;
use App\Http\Controllers\SeekerController;
use App\Http\Controllers\SeekerSkillController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CompanyMiddleware;
use App\Http\Middleware\SeekerMiddleware;
use Illuminate\Support\Facades\Route;

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
    // show all seeker posts by seeker id
    Route::get('/seeker_posts_by_id/{seeker}',[FreelancePostController::class,'getFreelancePostsById'])->name('api.freelance_post.getFreelancePostsById');


    //show  experience by id
    Route::get('/experiences/{experience}', [ExperienceController::class,'show'])->name('api.experiences.show');
    // show all seeker experiences by id
    Route::get('/seeker_experiences_by_id/{seeker}',[ExperienceController::class,'getExperiencesById'])->name('api.experiences.getExperiencesById');



    //show  education by id
    Route::get('/educations/{education}', [EducationController::class, 'show'])->name('api.education.show');
    // show all seeker educations by id
    Route::get('/seeker_education_by_id/{seeker}',[EducationController::class,'getEducationsById'])->name('api.education.getEducationsById');

    // show all seeker skills by id
    Route::get('/seeker_skills_by_id/{seeker}',[SeekerSkillController::class,'getSkillsById'])->name('api.skills.getSkillsById');

//
   Route::get('/job-post',[JobPostController::class,'index'])->name('api.job_post.index');

   Route::get('/job-post/{jobPost}', [JobPostController::class, 'show'])->name('api.job_post.show');

    //search for seeker by his name
    Route::get('/search_by_seeker_name/{seekerName}',[SeekerController::class,'searchBySeeker'])->name('api.search.searchBySeeker');


    //get all  applicants on job post by job post id
    Route::get('/get_applicants_job_post/{jobPost}',[ApplicantsJobPostController::class,'getApplicantsByJobId'])->name('api.job_post.getApplicantsByJobId');

    //get all applicants on freelance post by freelance post id
    Route::get('/freelance_applicants/{freelancePost}',[ApplicantsFreelancePostController::class,'getApplicantsByFreelanceId'])->name('api.freelance_applicants.getApplicantsByFreelanceId');


    // get all interview and interview by id
    Route::get('/interview',[InterviewController::class,'index'])->name('api.interview.index');
    Route::get('/interview/{interview}',[InterviewController::class,'show'])->name('api.interview.show');

    //get company interviews by company id for admin
    Route::get('/company-interview/{company}',[InterviewController::class,'companyInterview'])->name('api.interview.companyInterview');


    Route::get('/contracts',[ContractController::class,'index'])->name('api.contract.index');
    Route::get('/contracts/{contract}',[ContractController::class,'show'])->name('api.contract.show');
    Route::get('/company-contracts/{company}',[ContractController::class,'companyContract'])->name('api.contract.companyContract');
    Route::get('/my-company-contracts',[ContractController::class,'myCompanyContract'])->name('api.contract.myCompanyContract');
    Route::get('/seeker-contracts/{seeker}',[ContractController::class,'seekerContract'])->name('api.contract.seekerContract');
    Route::get('/my-seeker-contracts',[ContractController::class,'mySeekerContract'])->name('api.contract.mySeekerContract');

    Route::post('/contract',[ContractController::class,'store'])->name('api.contract.store');
    Route::post('/contract/{contract}',[ContractController::class,'update'])->name('api.contract.update');
    Route::delete('/contract/{contract}',[ContractController::class,'destroy'])->name('api.contract.destroy');



    Route::middleware([SeekerMiddleware::class])->group(function () {



        //get seeker profile
        Route::get('/get_seeker_profile',[SeekerController::class,'getMySeeker'])->name('api.seekers.getMySeeker');
        //create seeker profile
        Route::post('/seekers', [SeekerController::class, 'store'])->name('api.seekers.store');
        //modify seeker profile
        Route::post('/update_seeker_profile',[SeekerController::class,'update'])->name('api.seekers.update');
        //delete seeker profile
       Route::delete('/seekers',[SeekerController::class,'destroy'])->name('api.seekers.destroy');

       // Company Rating
       Route::post('/company-rating/{company}',[CompanyController::class,'rating'])->name('api.company.rating');
       // Seeker Rating
       Route::post('/seeker-rating/{seeker}',[SeekerController::class,'rating'])->name('api.seekers.rating');



        // show all seeker experiences
        Route::get('/my_experiences',[ExperienceController::class,'getMyExperiences'])->name('api.experiences.getMyExperiences');
        //add experiences
        Route::post('/experiences', [ExperienceController::class, 'store'])->name('api.experiences.store');
        //modify the experiences
        Route::post('/experiences/{experience}',[ExperienceController::class,'update'])->name('api.experiences.update');
        //delete experiences
        Route::delete('/experiences/{experience}',[ExperienceController::class,'destroy'])->name('api.experiences.destroy');


        // show all seeker educations
        Route::get('/my_educations',[EducationController::class,'getMyEducations'])->name('api.educations.getMyEducations');
        //add educations
        Route::post('/educations', [EducationController::class, 'store'])->name('api.educations.store');
        //modify the educations
        Route::post('/educations/{education}',[EducationController::class,'update'])->name('api.educations.update');
        //delete educations
        Route::delete('/educations/{education}',[EducationController::class,'destroy'])->name('api.educations.destroy');

        // show all seeker skills
        Route::get('/my_skills',[SeekerSkillController::class,'getMySkills'])->name('api.skills.getMySkills');
        //add skills
        Route::post('/skills', [SeekerSkillController::class, 'store'])->name('api.skills.store');
        //modify the skills
        Route::post('/seeker-skills/{seekerSkill}',[SeekerSkillController::class,'update'])->name('api.skills.update');
        //delete skills
        Route::delete('/seeker-skills/{seekerSkill}',[SeekerSkillController::class,'destroy'])->name('api.skills.destroy');


        // show all  freelance applicants for seeker
        Route::get('/my_freelance_applicants',[ApplicantsFreelancePostController::class,'getMyApplicants'])->name('api.applicants-freelance-post.getMyApplicants');
        //show  freelance applicant by id
        Route::get('/applicants-freelance-post/{applicantsFreelancePost}', [ApplicantsFreelancePostController::class, 'show'])->name('api.applicants-freelance-post.show');
        //add freelance applicants
        Route::post('/applicants-freelance-post', [ApplicantsFreelancePostController::class, 'store'])->name('api.applicants-freelance-post.store');
        //delete freelance applicants
        Route::delete('/applicants-freelance-post/{applicantsFreelancePost}',[ApplicantsFreelancePostController::class,'destroy'])->name('api.applicants-freelance-post.destroy');

        //show all job applicants for seeker
        Route::get('/my_job_applicants',[ApplicantsJobPostController::class,'getMyApplicants'])->name('api.applicants-job-post.getMyApplicants');
        //show  job applicant by id
        Route::get('/job_applicants/{applicantsJobPost}', [ApplicantsJobPostController::class, 'show'])->name('api.job_applicants.show');
        //add job applicants
        Route::post('/job_applicants', [ApplicantsJobPostController::class, 'store'])->name('api.job_applicants.store');
        //delete job applicants
        Route::delete('/job_applicants/{applicantsJobPost}',[ApplicantsJobPostController::class,'destroy'])->name('api.job_applicants.destroy');



        // show all seeker posts
        Route::get('/seeker_posts',[FreelancePostController::class,'getFreelancePosts'])->name('api.freelance_post.getFreelancePosts');
        //add freelance post from seeker
        Route::post('/freelance_post', [FreelancePostController::class, 'store'])->name('api.freelance_post.store');
        //modify the freelance post
        Route::post('/freelance_post/{freelancePost}',[FreelancePostController::class,'update'])->name('api.freelance_post.update');
        //delete freelance post
        Route::delete('/freelance_post/{freelancePost}',[FreelancePostController::class,'destroy'])->name('api.freelance_post.destroy');

        // show all favorite posts for seeker
        Route::get('/favorite_freelance',[FavoriteFreelanceController::class,'getMyFavoriteFreelance'])->name('api.favorite_freelance_post.getMyFavoriteFreelance');
        //get favorite post by id
        Route::get('/favorite_freelance_post/{favoriteFreelance}',[FavoriteFreelanceController::class,'show'])->name('api.favorite_freelance_post.show');
        //add favorite posts
        Route::post('/favorite_freelance_post', [FavoriteFreelanceController::class, 'store'])->name('api.favorite_freelance_post.store');
        //delete favorite posts
        Route::delete('/favorite_freelance_post/{favoriteFreelance}',[FavoriteFreelanceController::class,'destroy'])->name('api.favorite_freelance_post.destroy');

        // show all favorite job posts for seeker
        Route::get('/favorite_job',[FavoriteJobController::class,'getMyFavoriteJobs'])->name('api.favorite_job_post.getMyFavoriteJobs');
        //get favorite  job post by id
        Route::get('/favorite_job_post/{favoriteJob}',[FavoriteJobController::class,'show'])->name('api.favorite_job_post.show');
        //add favorite  job posts
        Route::post('/favorite_job_post', [FavoriteJobController::class, 'store'])->name('api.favorite_job_post.store');
        //delete favorite job posts
        Route::delete('/favorite_job_post/{favoriteJob}',[FavoriteJobController::class,'destroy'])->name('api.favorite_job_post.destroy');






        // seeker accept interview
        Route::post('/accept-interview/{interview}',[InterviewController::class,'seekerAcceptInterview'])->name('api.interview.seekerAcceptInterview');

    });
    Route::middleware([CompanyMiddleware::class])->group(function (){

        Route::get('/my-profile-company',[CompanyController::class,'getMyCompany'])->name('api.companies.getMyCompany');
        Route::post('/companies',[CompanyController::class,'store'])->name('api.companies.store');
        Route::post('/companies/update',[CompanyController::class,'update'])->name('api.companies.update');
        Route::delete('/companies/{company}',[CompanyController::class,'destroy'])->name('api.companies.destroy');



        Route::get('/my-job-posts',[JobPostController::class,'getMyJobPosts'])->name('api.companies.getMyJobPosts');

        Route::post('/job-post',[JobPostController::class,'store'])->name('api.job-post.store');
        Route::post('/job-post/{jobPost}',[JobPostController::class,'update'])->name('api.job-post.update');
        Route::delete('/job-post/{jobPost}',[JobPostController::class,'destroy'])->name('api.job-post.destroy');



        Route::get('/my-freelance-posts',[FreelancePostController::class,'getFreelancePosts'])->name('api.companies.getFreelancePosts');

        Route::post('/company/freelance-post', [FreelancePostController::class,'store'])->name('api.freelance-post.store');
        Route::post('/company/freelance-post/{freelancePost}',[FreelancePostController::class,'update'])->name('api.freelance-post.update');
        Route::delete('/company/freelance-post/{freelancePost}',[FreelancePostController::class,'destroy'])->name('api.freelance-post.destroy');



        Route::get('/my-company-interview',[InterviewController::class,'getMyInterview'])->name('api.interview.getMyInterview');

        Route::post('/interview',[InterviewController::class,'store'])->name('api.interview.store');
        Route::post('/interview/{interview}',[InterviewController::class,'update'])->name('api.interview.update');
        Route::delete('/interview/{interview}',[InterviewController::class,'destroy'])->name('api.interview.destroy');


    });


});
