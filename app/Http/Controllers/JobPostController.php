<?php

namespace App\Http\Controllers;

use App\Http\Resources\JobPostsResource;
use App\Models\Company;
use App\Models\JobPost;
use App\Http\Requests\StoreJobPostRequest;
use App\Http\Requests\UpdateJobPostRequest;
use App\Models\RequiredSkill;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobPosts = JobPost::with('category','skill')->get();
        return JobPostsResource::collection($jobPosts);
    }

    public function companyJobPost(Company $company)
    {
        try {
            $jobPosts = JobPost::with(['category', 'skill'])
                ->where('company_id', $company->id)
                ->get();
            if ($jobPosts->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No job posts found for this company',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => JobPostsResource::collection($jobPosts),
                'message' => 'Job posts retrieved successfully',
                'status' => 200,
            ], 200);
        } catch (Exception $e) {
            Log::error('Error retrieving company job posts: ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving job posts',
                'status' => 500,
            ], 500);
        }
    }

    public function getMyJobPosts()
    {
        try {
            // $this->authorize('view', $company);

            $user = Auth::user();
            $company=Company::where('user_id', $user->id)->first();

            $jobPosts = JobPost::with(['category', 'skill'])
                ->where('company_id', $company->id)
                ->get();

            if ($jobPosts->isEmpty()) {
                return response()->json([
                    'data' => [],
                    'message' => 'No job posts found for this company',
                    'status' => 404,
                ], 404);
            }

            return response()->json([
                'data' => JobPostsResource::collection($jobPosts),
                'message' => 'Job posts retrieved successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving seeker job posts : ' . $e->getMessage());
            return response()->json([
                'data' => [],
                'message' => 'An error occurred while retrieving job posts ',
                'status' => 500,
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJobPostRequest $request)
    {
        try {
            $user = Auth::user();
            $company=Company::where('user_id', $user->id)->first();

            if($company) {
                $jobPost = JobPost::create([

                    'company_id' => $company->id,
                    'category_id' => $request->category_id,

                    'title' => $request->title,
                    'description' => $request->description,
                    'job_requirement' => $request->job_requirement,
                    'address' => $request->address,

                    'gender' => $request->gender,
                    'min_age' => $request->min_age,
                    'max_age' => $request->max_age,

                    'scientific_level' => $request->scientific_level,
                    'job_type' => $request->job_type,
                    'experience_years' => $request->experience_years,
                    'min_salary' => $request->min_salary,
                    'max_salary' => $request->max_salary,

                ]);
            }

            if ($request->has('skill_ids') && is_array($request->skill_ids)) {
                foreach ($request->skill_ids as $skill_id) {
                    RequiredSkill::create([
                        'job_post_id' => $jobPost->id,
                        'skill_id' => $skill_id,
                    ]);
                }
            }
        } catch (Exception $e) {
            Log::error('Error creating job post :' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while creating the job post ',
                'status' => 500,
            ], 500);
        }

        $jobPost->load(['category', 'skill']);
        return response()->json([
            'data' =>  JobPostsResource::collection(collect([$jobPost])),
            'message' => ' job post created successfully',
            'status' => 200,
        ],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(JobPost $jobPost)
    {
        $jobPost->load(['category', 'skill']);
        return JobPostsResource::collection(collect([$jobPost]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPost $jobPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPostRequest $request, JobPost $jobPost)
    {
        $jobPost = JobPost::findOrFail($jobPost->id);

        try {

            $this->authorize('update', $jobPost);

            $jobPost->update($request->only(['category_id', 'title', 'description',
            'job_requirement', 'address', 'gender', 'min_age', 'max_age', 'scientific_level', 'job_type',
            'experience_years', 'min_salary', 'max_salary']));


            if ($request->has('skill_ids') && is_array($request->skill_ids)) {

                $jobPost->skill()->detach();

                foreach ($request->skill_ids as $skill_id) {
                    $jobPost->skill()->attach($skill_id);
                }
            }
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 403);
        }
        $jobPost->load(['category', 'skill']);
        return response()->json([
            'data' => JobPostsResource::collection(collect([$jobPost])),
            'message' => 'Job post updated successfully',
            'status' => 200,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPost $jobPost)
    {
        try {

            $jobPost->skill()->detach();

            $jobPost->delete();

            return response()->json([
                'data' => '',
                'message' => 'Job post deleted successfully',
                'status' => 200,
            ], 200);

        } catch (Exception $e) {
            Log::error('Error deleting job post: ' . $e->getMessage());
            return response()->json([
                'data' => '',
                'message' => 'An error occurred while deleting the job post',
                'status' => 500,
            ], 500);
        }
    }


}
