<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\FreelancePostsResource;
use App\Http\Resources\JobPostsResource;
use App\Models\Company;
use App\Models\FreelancePost;
use App\Models\JobPost;
use App\Models\Seeker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FilterController extends Controller
{
    public function filterCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed',
                'status' => 422
            ], 422);
        }

        $filters = $request->only(['city', 'country', 'industry']);
        $companies = Company::filter($filters)->get();

        return response()->json([
            'data' => CompanyResource::collection($companies),
            'message' => 'Companies retrieved successfully',
            'status' => 200
        ], 200);
    }
    public function filterFreelancePostForCompany()
    {
        // Find the seeker
        $user =Auth::user();

        $company = Company::where('user_id', $user->id)->with(['location', 'communication'])->firstOrFail();

        // Get the filtered job posts
        $freelancePosts = FreelancePost::autoCompanyFreelancePosts($company)->get();

        return response()->json([
            'data' => FreelancePostsResource::collection($freelancePosts),
            'message' => 'Filtered freelance posts retrieved successfully',
            'status' => 200
        ], 200);
    }

    public function filterJobPosts(Request $request)
    {
        $filters = $request->only([
            'title', 'company_id', 'category_id', 'address', 'gender', 'scientific_level',
            'job_type', 'experience_years', 'age', 'salary', 'status','skills'
        ]);


        $jobPosts = JobPost::filter($filters)->get();

        return response()->json([
            'data' => $jobPosts,
            'message' => 'Job posts retrieved successfully',
            'status' => 200
        ], 200);
    }

    public function filterJobPostsForSeeker()
    {
        // Find the seeker
        $user =Auth::user();

        $seeker = Seeker::with(['location','education','experience','skill'])->findOrFail($user->id);

        // Get the filtered job posts
        $jobPosts = JobPost::autoJobPosts($seeker)->get();

        return response()->json([
            'data' => JobPostsResource::collection($jobPosts),
            'message' => 'Filtered job posts retrieved successfully',
            'status' => 200
        ], 200);
    }


    public function filterFreelancePostForSeeker()
    {
        // Find the seeker
        $user =Auth::user();

        $seeker = Seeker::with(['location', 'education', 'experience','skill'])->findOrFail($user->id);

        // Get the filtered job posts
        $freelancePost = FreelancePost::autoSeekerFreelancePosts($seeker)->get();

        return response()->json([
            'data' => FreelancePostsResource::collection($freelancePost),
            'message' => 'Filtered freelance posts retrieved successfully',
            'status' => 200
        ], 200);
    }


}
